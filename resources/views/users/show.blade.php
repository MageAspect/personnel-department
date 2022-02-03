<?php

/**
 * @author mosowell https://github.com/mosowell
 */
?>

@extends('layouts.app')

@section('content')
    <user-details-page :edit="false" :user-id="{{ $userId }}"/>
@endsection
