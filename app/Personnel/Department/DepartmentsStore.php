<?php

/**
 * @author mosowell https://github.com/mosowell
 */

namespace App\Personnel\Department;


use App\Models\Department;
use App\Models\User;
use App\Personnel\Users\UsersStore;
use App\Personnel\Users\UsersStoreException;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class DepartmentsStore
{
    private User $currentUser;
    private UsersStore $usersStore;
    private ?Department $department;

    public function __construct(User $currentUser, UsersStore $usersStore = null, Department $department = null)
    {
        $this->currentUser = $currentUser;
        $this->usersStore = $usersStore ?? new UsersStore($currentUser);

        $this->department = $department ?? new Department();
    }

    /**
     * @throws
     */
    public function findDepartments(
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
            throw new DepartmentsStoreException('Не удалость найти отделы', 0, $e);
        }
    }

    /**
     * @throws DepartmentsStoreException
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
            $d->head = $this->usersStore->findById($department->head_id);

            $membersIds = array_map(fn($user) => $user->id, $department->members->all());

            $d->members = $this->usersStore->findUsers(array('id' => $membersIds))->all();

            return $d;
        } catch (Exception $e) {
            throw new DepartmentsStoreException('Не удалость найти отдел', 0, $e);
        }
    }

    /**
     * @throws DepartmentsStoreException
     */
    public function canUpdate(int $id): bool {
        try {
            $d = $this->department::query()->findOrFail($id);
        } catch (Exception $e) {
            throw new DepartmentsStoreException('Не удалость найти отдел', 0, $e);
        }

        try {
            return $this->currentUser->can('update', $d);
        } catch (Exception $e) {
            throw new DepartmentsStoreException('Не удалость проверить права на редактирование отдела', 0, $e);
        }
    }

    /**
     * @throws UsersStoreException
     */
    protected function collectDepartmentsEntities(array $departments, bool $withMembers = false): Collection
    {
        $departmentsEntities = array();
        foreach ($departments as $department) {
            $d = new DepartmentEntity();
            $d->id = (int) $department->id;
            $d->name = (string) $department->name;
            $d->description = (string) $department->description;
            $d->head->id = (int) $department->head_id;
            $departmentsEntities[$d->id] = $d;
        }

        $heads = array();
        $headsIds = array_map(fn(DepartmentEntity $department) => $department->head->id, $departmentsEntities);
        if (!empty($headsIds)) {
            $heads = $this->usersStore->findUsers(array('id' => $headsIds));
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
