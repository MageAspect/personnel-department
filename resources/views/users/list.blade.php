<?php

/**
 * @author mosowell https://github.com/mosowell
 */
?>

@extends('layouts.app')

@section('content')
    <user-list-page :can-store="{{$canStore ? '1' : '0'}}"></user-list-page>
@endsection
