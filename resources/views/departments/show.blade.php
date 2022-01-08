<?php

/**
 * @author mosowell https://github.com/mosowell
 */

use App\Personnel\DepartmentEntry;


/** @var DepartmentEntry $department */
?>

@extends('layouts.app')

@section('content')
    <department-show edit-url="{{ route('departments.edit', ['department' => $department->id]) }}"
                     list-url="{{ route('departments.index') }}"
                     :json-department='@json($department, JSON_UNESCAPED_UNICODE)'
    >
    </department-show>
@endsection
