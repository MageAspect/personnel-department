<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentEditRequest;
use App\Models\Department;
use App\Personnel\Department\DepartmentEntity;
use App\Personnel\Department\DepartmentsStore;
use App\Personnel\Department\DepartmentsStoreException;
use App\Personnel\Users\UserEntity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class DepartmentController extends Controller
{
    public function index(Request $request, DepartmentsStore $departmentsStore): View
    {
        $filter = array();
        if ($request->get('find')) {
            $filter['find'] = $request->get('find');
        }
        try {
            $departments = $departmentsStore->findDepartments($filter, array(), 8);
        } catch (DepartmentsStoreException $e) {
            return view('departments.list', array('error' => $e->getMessage()));
        }

        return view('departments.list', ['departments' => $departments]);
    }

    public function show(int $id, DepartmentsStore $departmentsStore): View
    {
        try {
            $d = $departmentsStore->findById($id);
        } catch (DepartmentsStoreException $e) {
            return view('departments.show', array('error' => $e->getMessage()));
        }

        return view('departments.show', array('department' => $d));
    }

    public function edit(int $id, DepartmentsStore $departmentsStore): View
    {
        $viewData = array();
        try {
            if(!$departmentsStore->canUpdate($id)) {
                $viewData['error'] = 'Недостаточно прав для редактирования отдела';
            } else {
                $viewData['department'] = $departmentsStore->findById($id);
            }
        } catch (DepartmentsStoreException $e) {
            $viewData = array('error' => $e->getMessage());
        }

        return view('departments.edit', $viewData);
    }


    public function update(DepartmentEditRequest $request, DepartmentsStore $departmentsStore, int $id): void
    {
        Gate::authorize('update', Department::class);

        $department = Department::query()->findOrFail($id);

        $department->name = $request->get('name');
        $department->description = $request->get('description');
        if (Gate::allows('updateHead', Department::class)) {
            $department->head_id = $request->get('headId');
        }
        $department->members()->sync($request->get('membersIds'));

        $department->save();
    }

    public function create(): View
    {
        if (!Gate::allows('store', Department::class)) {
            return view('departments.edit', ['cannotEdit' => true]);
        }

        $department = new DepartmentEntity(0);
        $department->name = 'Новый отдел';
        $department->head = UserEntity::fromModel(auth()->user());

        return view('departments.edit', ['department' => $department]);
    }

    public function store(Request $request): JsonResponse
    {
        Gate::authorize('store', Department::class);

        $department = new Department();
        $department->name = $request->get('name');
        $department->description = $request->get('description');
        if (Gate::allows('updateHead', Department::class)) {
            $department->head_id = $request->get('headId');
        }
        $department->members()->sync($request->get('membersIds'));
        $department->save();

        return response()->json([
            'id' => $department->id
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        Department::query()->where('id', $id)->delete();
        return back();
    }
}
