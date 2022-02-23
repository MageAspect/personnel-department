<?php

/**
 * @author mosowell https://github.com/mosowell
 */

namespace App\Personnel\Department;


use App\Models\Department;
use App\Models\User;
use App\Personnel\Users\UserEntity;
use App\Personnel\Users\UserStore;
use App\Personnel\Users\UserStoreException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\UnauthorizedException;


class DepartmentStore
{
    private User $currentUser;
    private UserStore $userStore;
    private ?Department $department;

    public function __construct(User $currentUser, UserStore $userStore, Department $department)
    {
        $this->currentUser = $currentUser;
        $this->userStore = $userStore;
        $this->department = $department;
    }

    /**
     * @throws
     */
    public function paginateDepartments(
        array $filter = array(),
        array $sort = array(),
        int $paginate = 10
    ): LengthAwarePaginator {
        try {
            $q = $this->department::query();
            $q->with(['head']);

            if (!empty($filter['find']) && (string) $filter['find']) {
                $q->where('name', 'ilike', "%{$filter['find']}%");
                unset($filter['find']);
            }

            $q->where($filter);
            foreach ($sort as $column => $direction) {
                $q->orderBy($column, $direction);
            }

            $departments = $q->paginate($paginate);

            $departments->setCollection($this->collectDepartmentsEntities($departments->items()));
            return $departments;
        } catch (Exception $e) {
            throw new DepartmentStoreException('Не удалость найти отделы', 0, $e);
        }
    }

    /**
     * @throws DepartmentStoreException
     */
    public function findUserDepartments(int $userId): Collection {
        try {
            $q = $this->department::query();
            $q->select('*');
            $q->with('head');

            $q->whereHas('members', function($q) use($userId) {
                $q->whereIn('user_id', array($userId));
            });

            $q->orWhere('head_id', $userId);

            $departments = $q->get();

            return $this->collectDepartmentsEntities($departments->all());
        } catch (Exception $e) {
            throw new DepartmentStoreException('Не удалось получить отделы пользователя', 0 ,$e);
        }
    }

    /**
     * @throws DepartmentStoreException
     */
    public function findById(int $id): DepartmentEntity
    {
        try {
            $department = $this->department::with(['head', 'members'])
                ->select('*')
                ->where('id', $id)
                ->first();

            if (!$department) {
                throw new DepartmentNotFoundException();
            }

            $d = new DepartmentEntity();
            $d->id = (int) $department->id;
            $d->name = (string) $department->name;
            $d->description = (string) $department->description;
            $d->head = $this->userStore->findById($department->head_id);

            $membersIds = array_map(fn($user) => $user->id, $department->members->all());

            $d->members = $this->userStore->findUsers(array('id' => $membersIds))->all();

            return $d;
        } catch (Exception $e) {
            throw new DepartmentStoreException('Не удалость найти отдел', 0, $e);
        }
    }

    /**
     * @throws DepartmentStoreException
     */
    public function canUpdate(int $id): bool
    {
        try {
            $d = $this->department::query()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new DepartmentStoreException(
                'Не удалость проверить права на редактирование отдела - отдел не найден',
                0,
                $e
            );
        }

        return $this->currentUser->can('update', $d);
    }

    /**
     * @throws DepartmentStoreException
     */
    public function canDelete(int $id): bool
    {
        try {
            $d = $this->department::query()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new DepartmentStoreException(
                'Не удалость проверить права на удаления отдела - отдел не найден',
                0,
                $e
            );
        }

        return $this->currentUser->can('delete', $d);
    }

    public function canStore(): bool
    {
        return $this->currentUser->can('store', Department::class);
    }

    /**
     * @throws DepartmentStoreException
     * @throws UnauthorizedException
     */
    public function update(DepartmentEntity $departmentEntity): void
    {
        if (!$this->canUpdate($departmentEntity->id)) {
            throw new UnauthorizedException('Недостаточно прав для редактирование отдела');
        }

        try {
            $department = $this->department::query()->findOrFail($departmentEntity->id);
        } catch (ModelNotFoundException $e) {
            throw new DepartmentStoreException('Не удалость обновил отдел - отдел не найден', 0, $e);
        }

        try {
            $department->name = $departmentEntity->name;
            $department->description = $departmentEntity->description;

            if ($this->currentUser->can('updateHead', $department)) {
                $department->head_id = $departmentEntity->head->id;
            }

            $membersIds = array_map(fn(UserEntity $user) => $user->id, $departmentEntity->members);

            $department->members()->sync($membersIds);

            $department->save();
        } catch (Exception $e) {
            throw new DepartmentStoreException(
                'Не удалость обновил отдел',
                0,
                $e
            );
        }
    }

    /**
     * @throws DepartmentStoreException
     * @throws UnauthorizedException
     */
    public function delete(int $id): void
    {
        if (!$this->canDelete($id)) {
            throw new UnauthorizedException('Недостаточно прав для удаления отдела');
        }

        try {
            $department = $this->department::query()->findOrFail($id);
        } catch (Exception $e) {
            throw new DepartmentStoreException('Не удалость удалить отдел - отдел не найден', 0, $e);
        }

        try {
            $department->delete();
        } catch (Exception $e) {
            throw new DepartmentStoreException('Ошибка во время удаления отдела', 0, $e);
        }
    }

    /**
     * @throws DepartmentStoreException
     * @throws UnauthorizedException
     */
    public function store(DepartmentEntity $departmentEntity): int
    {
        if (!$this->canStore()) {
            throw new UnauthorizedException('Недостаточно прав для добавления отдела');
        }

        try {
            $department = new Department();

            $department->name = $departmentEntity->name;
            $department->description = $departmentEntity->description;
            $department->head_id = $departmentEntity->head->id;
            $membersIds = array_map(fn(UserEntity $user) => $user->id, $departmentEntity->members);
            $department->save();

            $department->members()->sync($membersIds);
        } catch (Exception $e) {
            throw new DepartmentStoreException('Не удалость добавить отдел', 0, $e);
        }

        return $department->id;
    }

    /**
     * @throws UserStoreException
     */
    protected function collectDepartmentsEntities(array $departments): Collection
    {
        $departmentsEntities = array();
        foreach ($departments as $department) {
            $d = new DepartmentEntity();
            $d->id = (int) $department->id;
            $d->name = (string) $department->name;
            $d->description = (string) $department->description;
            $d->head->id = (int) $department->head_id;

            $d->canBeUpdated = $this->currentUser->can('update', $department);
            $d->canBeDeleted = $this->currentUser->can('delete', $department);

            $departmentsEntities[$d->id] = $d;
        }

        $heads = array();
        $headsIds = array_map(fn(DepartmentEntity $department) => $department->head->id, $departmentsEntities);
        if (!empty($headsIds)) {
            $heads = $this->userStore->findUsers(array('id' => $headsIds));
        }

        foreach ($heads as $head) {
            foreach ($departmentsEntities as $entry) {
                if ($entry->head->id == $head->id) {
                    $entry->head = $head;
                }
            }
        }

        return collect($departmentsEntities);
    }
}
