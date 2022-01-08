<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Personnel\Department\DepartmentStore;
use App\Personnel\DepartmentEntry;
use Illuminate\Http\Request;


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

    public function edit(int $id) {
        return view('departments.edit');
    }

    public function show(int $id) {
        $d = Department::query()->find($id);
        return view('departments.show', ['department' => DepartmentEntry::fromModel($d)]);
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id) {
        Department::query()->where('id', $id)->delete();
        return back();
    }
}
