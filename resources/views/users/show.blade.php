<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */
?>

@extends('layouts.app')

@section('content')
    <user-profile-page :edit-mode="false" :user-id="'{{ $userId }}'"/>
@endsection
