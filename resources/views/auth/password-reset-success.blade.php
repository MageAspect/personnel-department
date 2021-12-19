<?php

/**
 * @author Mark Prohorov <mark.proxorofff@gmail.com>
 */
?>

@extends('layouts.auth')

@section('content')
    <div class="flex justify-center items-center grow">
        <div class="max-w-xl bg-oceanic py-12 w-96">
            <div class="border-l-2 border-blue px-16 flex items-center justify-between h-12">
                <span class="text-gray-light font-bold tracking-wide">ВОССТАНОВЛЕНИЕ ПАРОЛЯ</span>
            </div>
            <div class="px-16 text-base  mt-8 tracking-wide text-center text-green">
                Пароль успешно сброшен!
            </div>
            <div class="mt-12 flex justify-center">
                <a href="{{ route('auth.login') }}" class="
                            border-2 border-blue transition text-sm
                            text-center px-12 py-4 text-blue
                            hover:text-gray-light hover:bg-blue"
                >
                    ВОЙТИ
                </a>
            </div>
        </div>
    </div>
@endsection
