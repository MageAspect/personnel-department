<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentEditRequest;
use App\Personnel\Department\DepartmentEntity;
use App\Personnel\Department\DepartmentStore;
use App\Personnel\Department\DepartmentStoreException;
use App\Personnel\Users\UserEntity;
use App\Personnel\Users\UserStore;
use App\Personnel\Users\UserStoreException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    public function index(Request $request, DepartmentStore $departmentsStore): View
    {
        $filter = array();
        if ($request->get('find')) {
            $filter['find'] = $request->get('find');
        }

        try {
            $departments = $departmentsStore->paginateDepartments($filter, array(), 8);
        } catch (DepartmentStoreException $e) {
            return view('departments.list', array('error' => $e->getMessage()));
        }

        return view('departments.list', ['departments' => $departments]);
    }

    public function show(int $id, DepartmentStore $departmentsStore): View
    {
        try {
            $d = $departmentsStore->findById($id);
        } catch (DepartmentStoreException $e) {
            return view('departments.show', array('error' => $e->getMessage()));
        }

        return view('departments.show', array('department' => $d));
    }

    public function edit(int $id, DepartmentStore $departmentsStore): View
    {
        try {
            if (!$departmentsStore->canUpdate($id)) {
                throw new UnauthorizedActionException('Недостаточно прав для редактирования отдела');
            }

            return view('departments.edit', array('department' => $departmentsStore->findById($id)));

        } catch (DepartmentStoreException|UnauthorizedActionException $e) {
            return view('departments.edit', array('error' => $e->getMessage()));
        }
    }


    public function update(
        DepartmentEditRequest $request,
        DepartmentStore $departmentsStore,
        int $id
    ): JsonResponse {
        $department = $this->createFromRequest($request);
        $department->id = $id;

        try {
            $departmentsStore->update($department);
        } catch (DepartmentStoreException $e) {
            return response()->json(
                array('error' => $e->getMessage()),
                 500
            );
        }

        return response()->json();
    }

    public function create(UserStore $userStore, DepartmentStore $departmentsStore, Request $request): View
    {
        try {
            if (!$departmentsStore->canStore()) {
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

    public function store(Request $request, DepartmentStore $departmentsStore): JsonResponse
    {
        $department = $this->createFromRequest($request);

        try {
            return response()->json(array(
                'id' => $departmentsStore->store($department)
            ));

        } catch (DepartmentStoreException $e) {
            return response()->json(
                array('error' => $e->getMessage()),
                500
            );
        }
    }

    public function destroy(int $id, DepartmentStore $departmentsStore): RedirectResponse
    {
        try {
            $departmentsStore->delete($id);
        } catch (DepartmentStoreException $e) {
            return back()->withErrors(array('deleteError' => $e->getMessage()));
        }

        return back();
    }

    public function findUserDepartments(DepartmentStore $departmentStore, int $userId): JsonResponse
    {
        try {
            $departments = $departmentStore->findUserDepartments($userId);

            return response()->json(
                array_values($departments->toArray()),
                200,
                array(),
                JSON_UNESCAPED_UNICODE
            );
        } catch (DepartmentStoreException $e) {
            return response()->json(
                array('error' => $e->getMessage()),
                500,
                array(),
                JSON_UNESCAPED_UNICODE 
            );
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
