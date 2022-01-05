<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    public function index()
    {
        return view('departments.list');
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
