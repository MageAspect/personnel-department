<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentEditRequest;
use App\Models\Department;
use App\Personnel\DepartmentEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class DepartmentController extends Controller
{
    public function index()
    {
        $ds = Department::query()->paginate(8);

        $departments = [];
        foreach ($ds as $d) {
            $departments[] = DepartmentEntry::fromModel($d);
        }

        return view('departments.list', ['departments' => $departments, 'links' => $ds->links()]);
    }

    public function edit(int $id)
    {
        if (!Gate::allows('update', Department::class)) {
            return view('departments.edit', ['cannotEdit' => true]);
        }

        $d = Department::query()->find($id);
        return view('departments.edit', ['department' => DepartmentEntry::fromModel($d)]);
    }

    public function show(int $id)
    {
        $d = Department::query()->find($id);
        return view('departments.show', ['department' => DepartmentEntry::fromModel($d)]);
    }

    public function update(DepartmentEditRequest $request, int $id)
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

    public function store(Request $request)
    {
        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id)
    {
        Department::query()->where('id', $id)->delete();
        return back();
    }
}
