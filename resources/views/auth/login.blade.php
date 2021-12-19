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
                <span class="text-gray-light font-bold">ВХОД</span>
                <a href="{{ route('auth.forgot-password') }}" class="
                        text-gray text-sm transition hover:text-gray-light
                    ">
                    забыли пароль?
                </a>
            </div>
            <form class="px-16" action="{{ route('auth.login-process') }}" method="post">
                @csrf

                <div class="mt-12 ">
                    <input class="
                                bg-oceanic pt-3 pb-2 text-gray-light
                                border-b border-gray-light text-base @error('email') border-red @enderror
                        " id="login" type="text" name="email" value="{{ old('email')  }}" placeholder="Email">
                    @error('email')
                    <div class="mt-4 text-sm text-red ">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-12">
                    <input class="
                                bg-oceanic pt-3 pb-2 text-gray-light
                                border-b border-gray-light text-base @error('password') border-red @enderror
                        " id="password" type="password" name="password" placeholder="Пароль">
                    @error('password')
                    <div class="mt-4 text-sm text-red ">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-16 flex justify-center">
                    <button class="
                            border-2 border-blue transition
                            text-center px-18 py-4 text-blue
                            hover:text-gray-light hover:bg-blue"
                            type="submit">
                        ВОЙТИ
                    </button>
                </div>

                @error('auth')
                <div class="mt-10 text-sm text-red text-center">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>
@endsection
