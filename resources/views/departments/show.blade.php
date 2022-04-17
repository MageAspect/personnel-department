<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */


/** @var \App\Personnel\Department\DepartmentEntity $department */

$error = $error ?? null;
?>

@extends('layouts.app')

@section('content')
    @if($error)
        <page-header class="bg-oce" title="Просмотр отдела">
            <template v-slot:icon>
                <i class="fas fa-layer-group"></i>
            </template>
            <template v-slot:buttons>
                <a href="{{ route('departments.index') }}" class="btn btn-light mr-4">
                    <span>К списку</span>
                </a>
            </template>
        </page-header>
        <error class="m-6 p-6 bg-oceanic-light" message="{{ $error }}"></error>
    @else
        <department-show edit-url="{{ route('departments.edit', ['department' => $department->id]) }}"
                         list-url="{{ route('departments.index') }}"
                         :json-department='@json($department, JSON_UNESCAPED_UNICODE)'
        >
        </department-show>
    @endif
@endsection
