<?php

/**
 * @author mosowell https://github.com/mosowell
 */

use App\Personnel\DepartmentEntry;


/** @var DepartmentEntry $department */
?>

@extends('layouts.app')

@section('content')
    @if(!($cannotEdit ?? false))
    <department-edit
        update-url="{{ route('departments.update', ['department' => $department->id]) }}"
        store-url="{{ route('departments.store') }}"
        list-url="{{ route('departments.index') }}"
        view-url="{{ route('departments.show', ['department' => $department->id]) }}"
        find-users-url="{{ route('users.find') }}"
        :json-department='@json($department, JSON_UNESCAPED_UNICODE)'>
    </department-edit>
    @else
        <page-header title="Редактирование отдела">
            <template v-slot:icon>
                <i class="fas fa-layer-group"></i>
            </template>
            <template v-slot:buttons>
                <a href="{{ route('departments.index') }}" class="btn btn-light mr-4">
                    <span>К списку</span>
                </a>
            </template>
        </page-header>
        <error class="m-6 p-6 bg-oceanic-light" message="Недостаточно прав для редактирования отдела"></error>
    @endif
@endsection

