<?php

/**
 * @author mosowell https://github.com/mosowell
 */
?>

@extends('layouts.app')

@section('content')
    <user-profile-page :edit-mode="false" :user-id="{{ $userId }}"/>
@endsection
