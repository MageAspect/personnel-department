<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */
?>

@extends('layouts.auth')

@section('content')
    <div class="flex justify-center items-center grow">
        <div class="max-w-xl bg-oceanic py-12 w-96">
            <div class="border-l-2 border-blue px-16 flex items-center justify-between h-12">
                <span class="text-gray-light font-bold tracking-wide">ВОССТАНОВЛЕНИЕ ПАРОЛЯ</span>
            </div>
            <form class="px-16" action="{{ route('auth.reset-password-process') }}" method="post">
                @csrf
                <div class="mt-12">
                    <input class="bg-oceanic pt-3 pb-2 text-gray-light
                                border-b border-gray-light text-base
                                @error('password') border-red @enderror"
                           id="password"
                           type="password"
                           name="password"
                           placeholder="Новый пароль"
                           value="{{ old('password') }}">
                    @error('password')
                    <div class="mt-4 text-sm text-red ">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="token" value="{{ $token ?? ''  }}">
                <input type="hidden" name="email" value="{{ $email ?? ''  }}">
                <div class="mt-12">
                    <input class="bg-oceanic pt-3 pb-2 text-gray-light
                                border-b border-gray-light text-base
                                @error('password_confirmed') border-red @enderror"
                           id="password"
                           type="password"
                           name="password_confirmation"
                           placeholder="Новый пароль ещё раз">
                    @error('password_confirmation')
                    <div class="mt-4 text-sm text-red ">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-16 flex justify-center">
                    <button class="border-2 border-blue transition text-sm
                                text-center px-12 py-4 text-blue
                                hover:text-gray-light hover:bg-blue"
                            type="submit">
                        ВОССТАНОВИТЬ
                    </button>
                </div>
                @error('reset')
                <div class="mt-10 text-sm text-red text-center">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>
@endsection
