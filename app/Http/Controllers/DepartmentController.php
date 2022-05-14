<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonHttpResponseException;
use App\Http\Requests\DepartmentEditRequest;
use App\Personnel\Department\DepartmentEntity;
use App\Personnel\Department\DepartmentStore;
use App\Personnel\Department\DepartmentStoreException;
use App\Personnel\User\UserEntity;
use App\Personnel\User\UserStore;
use App\Personnel\User\UserStoreException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DepartmentController extends Controller
{
    public function index(Request $request, DepartmentStore $departmentStore): View
    {
        $filter = array();
        if ($request->get('find')) {
            $filter['find'] = $request->get('find');
        }

        try {
            $departments = $departmentStore->paginateDepartments($filter, array(), 8);
        } catch (DepartmentStoreException $e) {
            return view('departments.list', array('error' => $e->getMessage()));
        }

        return view(
            'departments.list',
            array(
                'departments' => $departments,
                'canStore' => $departmentStore->canStore()
            )
        );
    }

    public function show(string $id, DepartmentStore $departmentStore): View
    {
        try {
            $d = $departmentStore->findById($id);
        } catch (DepartmentStoreException $e) {
            return view('departments.show', array('error' => $e->getMessage()));
        }

        return view('departments.show', array('department' => $d));
    }

    public function edit(string $id, DepartmentStore $departmentStore): View
    {
        try {
            if (!$departmentStore->canUpdate($id)) {
                throw new UnauthorizedActionException('Недостаточно прав для редактирования отдела');
            }

            return view('departments.edit', array('department' => $departmentStore->findById($id)));

        } catch (DepartmentStoreException|UnauthorizedActionException $e) {
            return view('departments.edit', array('error' => $e->getMessage()));
        }
    }


    public function update(
        DepartmentEditRequest $request,
        string $id,
        DepartmentStore $departmentStore
    ): JsonResponse|Response {
        $department = $this->createFromRequest($request);
        $department->id = $id;

        try {
            $departmentStore->update($department);
        } catch (DepartmentStoreException $e) {
            throw new JsonHttpResponseException($e->getMessage());
        }

        return response()->noContent();
    }

    public function create(UserStore $userStore, DepartmentStore $departmentStore, Request $request): View
    {
        try {
            if (!$departmentStore->canStore()) {
                throw new UnauthorizedActionException('Недостаточно прав для создания отдела');
            }

            $department = new DepartmentEntity();
            $department->name = 'Новый отдел';
            $department->head = $userStore->findById($request->user()->id);

            return view('departments.edit', array('department' => $department));
        } catch (UserStoreException|UnauthorizedActionException $e) {
            return view('departments.edit', array('error' => $e->getMessage()));
        }
    }

    public function store(Request $request, DepartmentStore $departmentStore): JsonResponse
    {
        $department = $this->createFromRequest($request);

        try {
            return $this->jsonResponse(array(
                'id' => $departmentStore->store($department)
            ));

        } catch (DepartmentStoreException $e) {
            throw new JsonHttpResponseException($e->getMessage());
        }
    }

    public function destroy(string $id, DepartmentStore $departmentStore): RedirectResponse
    {
        try {
            $departmentStore->delete($id);
        } catch (DepartmentStoreException $e) {
            return back()->withErrors(array('deleteError' => $e->getMessage()));
        }

        return back();
    }

    public function findUserDepartments(DepartmentStore $departmentStore, string $userId): JsonResponse
    {
        try {
            $departments = $departmentStore->findUserDepartments($userId);

            return $this->jsonResponse(
                array_values($departments->toArray())
            );
        } catch (DepartmentStoreException $e) {
            throw new JsonHttpResponseException($e->getMessage());
        }
    }

    protected function createFromRequest(Request $request): DepartmentEntity
    {
        $department = new DepartmentEntity();

        $department->name = $request->get('name');
        $department->description = $request->get('description');
        $department->head->id = $request->get('headId');

        foreach ($request->get('membersIds') as $memberId) {
            $m = new UserEntity();
            $m->id = $memberId;

            $department->members[] = $m;
        }

        return $department;
    }
}
