<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::query()->paginate(8);

        return view('departments.list', ['departments' => $departments]);
    }

    public function edit(int $id) {
        return view('departments.edit');
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
}
