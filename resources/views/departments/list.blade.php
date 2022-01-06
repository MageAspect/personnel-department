<?php

/**
 * @author mosowell https://github.com/mosowell
 */
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
    </page-header>
    <div class="grid p-6 grid-cols-departments gap-7">
        @foreach($departments as $department)
            <div class="border-oceanic-light border flex flex-col justify-between">
                <div class="p-4">
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
                                <a href="{{ $department->head->profilePath }}" class="mb-1 link-gray-light text-base">
                                    {{ $department->head->formattedName }}
                                </a>
                                <div class="text-gray text-xs">{{ $department->head->position }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="text-base leading-5 text-gray-lighter">
                        {{ $department->description }}
                    </div>
                </div>
                <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                    <a href="{{ route('departments.edit', ['department' => $department->id]) }}" class="p-2 uppercase font-medium hover:text-green transition">редактировать</a>
                    <form action="{{ route('departments.destroy', ['department' => $department->id]) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="p-2 uppercase font-medium hover:text-red transition">Удалить</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="px-6">
        {{ $departments->links('vendor.pagination.tailwind') }}
    </div>
@endsection
