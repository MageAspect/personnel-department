<?php

/**
 * @author mosowell https://github.com/mosowell
 */
?>

@extends('layouts.app')

@section('content')
    <user-details-page :edit-mode="true" :user-id="{{ $userId }}"/>
@endsection
