<?php

/**
 * @author mosowell https://github.com/mosowell
 */


/** @var \App\Personnel\Department\DepartmentEntity[] $departments */
?>

@extends('layouts.app')

@section('content')
    <page-header title="Список отделов">
        <template v-slot:icon>
            <i class="text-gray-dark fas fa-layer-group"></i>
        </template>
        <template v-slot:buttons>
            <a href="{{ route('departments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Добавить</span>
            </a>
        </template>
        <template v-slot:search>
            <form class="group relative ml-6" method="get">
                <svg width="20" height="20" fill="currentColor"
                     class="absolute left-3 top-1/2 -mt-2.5 text-gray-400 pointer-events-none
                            group-focus-within:text-blue-500"
                     aria-hidden="true">
                    <path fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414
                             1.414l-4.816-4.816A6 6 0 012 8z"/>
                </svg>
                <input class="focus:ring-2 focus:ring-blue focus:outline-none w-64 text-sm leading-6 bg-oceanic
                              text-gray-900 placeholder-gray-400 rounded-sm py-2 pl-10 ring-1 ring-gray-200 shadow-sm"
                       type="text"
                       name="find"
                       placeholder="Найти отдел..."
                       value="{{ request()->find }}">
            </form>
        </template>
    </page-header>
    <div class="grid p-6 grid-cols-departments gap-7">
        @foreach($departments as $department)
            <div class="border-oceanic-light border flex flex-col justify-between">
                <div class="p-4 pb-8">
                    <a href="{{ route('departments.show', ['department' => $department->id]) }}"
                       class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">
                        {{ $department->name }}
                    </a>
                    <div class="my-5">
                        <div class="flex">
                            <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                                <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                     style="@avatar($department->head->avatar)"></div>
                            </div>
                            <div class="ml-4 font-medium">
                                <a href="{{ $department->head->profileUrl }}" class="mb-1 link-gray-light text-base">
                                    {{ $department->head->getFormattedName() }}
                                </a>
                                <div class="text-gray text-xs">{{ $department->head->position }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="text-sm leading-6 text-gray-lighter">
                        {{ $department->description }}
                    </div>
                </div>
                @if ($department->canBeUpdated || $department->canBeDeleted)
                    <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-gray-lightest ">
                        @if ($department->canBeUpdated)
                            <a href="{{ route('departments.edit', ['department' => $department->id]) }}"
                               class="p-2 uppercase font-medium hover:text-green transition">редактировать</a>
                        @endif
                        @if ($department->canBeDeleted)
                            <form action="{{ route('departments.destroy', ['department' => $department->id]) }}"
                                  method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="p-2 uppercase font-medium hover:text-red transition">
                                    Удалить
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    <div class="px-6">
        {!! $departments->links() !!}
    </div>
@endsection
