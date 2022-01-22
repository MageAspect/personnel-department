<?php

/**
 * @author mosowell https://github.com/mosowell
 */

namespace App\Personnel\Users;


use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;


class UsersStore
{
    private User $currentUser;

    public function __construct(User $currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * @throws UsersStoreException
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
     * @throws UsersStoreException
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

            $q->selectRaw($selectSql, [$this->currentUser->id, $this->currentUser->id]);

            if (isset($filter['find'])) {
                $q->withFind($filter['find']);
                unset($filter['find']);
            }

            if (isset($filter['excludedIds'])) {
                $q->whereNotIn('id', $filter['excludedIds']);
                unset($filter['excludedIds']);
            }

            if (isset($filter['id'])) {
                is_array($filter['id']) ? $q->whereIn('id', $filter['id'])
                    : $q->where('id', $filter['id']);
            }

            foreach ($sort as $column => $direction) {
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
            throw new UsersStoreException('Failed to find users', 0, $e);
        }
    }

    /**
     * @throws UserNotFoundException
     */
    public function update(int $id, $fields): void
    {
        try {
            $user = $this->currentUser::query()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException("User with id: $id not found", 0, $e);
        }
    }

    public function add($fields): void
    {

    }

    /**
     * @throws UsersStoreException
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
            throw new UsersStoreException("Failed to delete User with id: $id", 0, $e);
        }
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
        $userEntity->avatar = (string) $user->avatar;
        $userEntity->profileUrl = route('users.show', ['user' => $user->id]);

        if ($this->currentUser->isAdministrator() || $user->can_current_user_view_work_fields) {
            $userEntity->salary = $user->salary;
            $userEntity->canViewFormFields = true;
        }

        return $userEntity;
    }
}
