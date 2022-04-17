<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */
?>

@extends('layouts.app')

@section('content')
    <user-list-page :can-store="{{$canStore ? '1' : '0'}}"></user-list-page>
@endsection
