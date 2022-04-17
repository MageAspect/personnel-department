<?php

/**
 * @author mosowell https://github.com/mosowell
 */

namespace App\Personnel\Users;


use App\Models\User;
use App\Personnel\Users\Journal\CareerJournalException;
use App\Personnel\Users\Journal\CareerJournalStore;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\UnauthorizedException;


class UserStore
{
    private User $currentUser;
    private CareerJournalStore $journalStore;

    public function __construct(User $currentUser, CareerJournalStore $journalStore)
    {
        $this->currentUser = $currentUser;
        $this->journalStore = $journalStore;
    }

    /**
     * @throws UserStoreException
     */
    public function findById(int $id): UserEntity
    {
        $user = $this->findUsers(array('id' => $id))
            ->first(fn(UserEntity $user) => $user->id === $id);

        if (!$user) {
            throw new UserNotFoundException();
        }
        return $user;
    }

    /**
     * @param  array{find: string, id: int|array, excludedIds: array}  $filter
     * @param  array{id: string, name: string, lastName: string, patromunic:string, email: string, salary: string}  $sort
     *         - значение каждого ключа - asc или desc
     * @param  int  $offset
     * @param  int  $limit
     * @return Collection
     * @throws UserStoreException
     */
    public function findUsers(array $filter, array $sort = [], int $offset = 0, int $limit = 20): Collection
    {
        try {
            $q = $this->currentUser::query();

            $q->select('*');

            $selectSql = '
                CASE
                    WHEN (
                        SELECT count(*) > 0
                        FROM departments
                            INNER JOIN user_department ud on departments.id = ud.department_id
                        WHERE users.id = ud.user_id
                            AND departments.head_id = ?
                    ) THEN TRUE
                    WHEN users.id = ? THEN TRUE
                    ELSE FALSE
                END as can_current_user_view_work_fields
            ';

            $q->selectRaw($selectSql, array($this->currentUser->id, $this->currentUser->id));

            $this->applyFindFilters($q, $filter);

            foreach ($sort as $column => $direction) {
                if ($column === 'lastName') {
                    $column = 'last_name';
                }
                $q->orderBy($column, $direction);
            }

            $q->offset($offset);
            $q->limit($limit);

            $users = $q->get();

            $usersEntities = [];
            foreach ($users as $u) {
                $usersEntities[$u->id] = $this->createUserEntity($u);
            }

            return collect($usersEntities);
        } catch (Exception $e) {
            throw new UserStoreException('Failed to find users', 0, $e);
        }
    }

    /**
     * @param  array{find: string, id: int|array, excludedIds: array}  $filter
     * @return int
     * @throws UserStoreException
     */
    public function findUsersCount(array $filter): int
    {
        try {
            $q = $this->currentUser::query();

            $q->selectRaw('count(*) as count');

            $this->applyFindFilters($q, $filter);

            return  $q->first()->count;
        } catch (Exception $e) {
            throw new UserStoreException('Failed to find users count', 0, $e);
        }
    }

    /**
     * @throws UserNotFoundException
     * @throws CareerJournalException
     */
    public function update(UserEntity $userEntity, ?string $password = null): void
    {
        try {
            $userToUpdate = $this->currentUser::query()
                ->with(array('departments', 'headOf'))
                ->findOrFail($userEntity->id);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException("User with id: $userEntity->id not found", 0, $e);
        }

        if (!$this->currentUser->can('update', $userToUpdate)) {
            throw new UnauthorizedException();
        }

        $this->updateModelFromEntity($userToUpdate, $userEntity, $password);

        if ($userToUpdate->isDirty('salary') || $userToUpdate->isDirty('position')) {
            $department = $userToUpdate->headOf ?: $userToUpdate->departments->first();
            $this->journalStore->addRecord(
                $userToUpdate->id,
                $userToUpdate->salary,
                $userToUpdate->position,
                $department?->id
            );
        }

        $userToUpdate->save();
    }

    public function canStore(): bool
    {
        return $this->currentUser->can('store', User::class);
    }

    public function canUpdate(int $id): bool
    {
        try {
            $userToUpdate = $this->currentUser::query()
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            return false;
        }

        return $this->currentUser->can('update', $userToUpdate);
    }

    /**
     * @throws CareerJournalException
     */
    public function store(UserEntity $userToStore, string $password): int
    {
        if (!$this->currentUser->can('store', User::class)) {
            throw new UnauthorizedException();
        }

        $modelUser = new User();
        $this->updateModelFromEntity($modelUser, $userToStore, $password);
        $modelUser->save();

        $this->journalStore->addRecord(
            $modelUser->id,
            $modelUser->salary,
            $modelUser->position
        );

        return $modelUser->id;
    }

    /**
     * @throws UserStoreException
     */
    public function delete(int $id): void
    {
        try {
            $user = $this->currentUser::query()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException("User with id: $id not found", 0, $e);
        }

        try {
            $user->delete();
        } catch (Exception $e) {
            throw new UserStoreException("Failed to delete User with id: $id", 0, $e);
        }
    }

    /**
     * @throws UserNotFoundException
     */
    public function isCorrectPassword(int $userId, string $password): bool {
        try {
            $user = $this->currentUser::query()
                ->findOrFail($userId);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException("User with id: $userId not found", 0, $e);
        }

        return Hash::check($password, $user->password);
    }

    public function isUniqueEmail(int $userId, string $email): bool {

        $q = $this->currentUser::query()
            ->select('email')
            ->where('email', $email);
        if ($userId > 0) {
            $q->where('id', '!=', $userId);
        }

        return !$q->first();
    }

    protected function createUserEntity(User $user): UserEntity
    {
        $userEntity = new UserEntity();
        $userEntity->id = (int) $user->id;
        $userEntity->name = (string) $user->name;
        $userEntity->lastName = (string) $user->last_name;
        $userEntity->patronymic = (string) $user->patronymic;
        $userEntity->email = (string) $user->email;
        $userEntity->position = (string) $user->position;
        $userEntity->phone = (string) $user->phone;
        $userEntity->avatar = $user->avatar ?: null;
        $userEntity->avatarPublicPath = $user->avatar ?
            Storage::disk('public')->url('avatars/' . $user->avatar)
            : null;
        $userEntity->profileUrl = route('users.show', array('user' => $user->id));

        if ($this->currentUser->isAdministrator() || $user->can_current_user_view_work_fields) {
            $userEntity->salary = $user->salary;
            $userEntity->salaryCanBeViewed = true;
        }

        $userEntity->canBeUpdated = $this->currentUser->can('update', $user);
        $userEntity->canBeDeleted = $this->currentUser->can('delete', $user);

        return $userEntity;
    }

    protected function applyFindFilters(Builder $query, array $filter): void {
        if (isset($filter['find'])) {
            $query->withFind($filter['find']);
            unset($filter['find']);
        }

        if (isset($filter['excludedIds'])) {
            $query->whereNotIn('id', $filter['excludedIds']);
            unset($filter['excludedIds']);
        }

        if (isset($filter['id'])) {
            is_array($filter['id']) ? $query->whereIn('id', $filter['id'])
                : $query->where('id', $filter['id']);
        }
    }

    protected function updateModelFromEntity(Model $model, UserEntity $entity, ?string $password = null): void {
        $model->name = $entity->name;
        $model->last_name = $entity->lastName;
        $model->patronymic = $entity->patronymic;
        $model->phone = $entity->phone;
        $model->email = $entity->email;
        $model->position = $entity->position;
        $model->salary = $entity->salary;
        $model->avatar = $entity->avatar;

        if ($password) {
            $model->password = Hash::make($password);
        }
    }
}
