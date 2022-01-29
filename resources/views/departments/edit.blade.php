<?php

/**
 * @author mosowell https://github.com/mosowell
 */

use App\Personnel\Department\DepartmentEntity;


/** @var DepartmentEntity $department */
/** @var string $error */

$error = $error ?? null;
?>

@extends('layouts.app')

@section('content')
    @if(!$error)
    <department-edit
        find-users-url="{{ route('users.find') }}"
        :json-department='@json($department, JSON_UNESCAPED_UNICODE)'>
    </department-edit>
    @else
        <page-header class="bg-oce" title="Редактирование отдела">
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

