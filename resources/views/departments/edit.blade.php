<?php

/**
 * @author mosowell https://github.com/mosowell
 */
?>

@extends('layouts.app')

@section('content')
    <department-edit
        @if (15)
            update-url="{{ route('departments.update', ['department' => 15]) }}"
        @else
            store-url="{{ route('departments.store') }}"
        @endif
        :id="15"
        token="{{ csrf_token() }}"
        name="Бухгалтерия"
        description="Привет мир"
        :head-id="45"
        :members-ids="[36]">

    </department-edit>
@endsection

