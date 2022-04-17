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
                <span class="text-gray-light font-bold tracking-wide">ВОСТАНОВЛЕНИЕ ПАРОЛЯ</span>
            </div>
            @if (!$mailSent)
                <div class="px-16 text-base text-gray mt-8 tracking-wide">
                    Мы отправим ссылку для восстановления на адрес
                </div>
                <form class="px-16" action="{{ route('auth.forgot-password-process') }}" method="post">
                    @csrf
                    <div class="mt-8">
                        <input class="bg-oceanic pt-3 pb-2 text-gray-light
                                    border-b border-gray-light text-base
                                    @error('email') border-red @enderror"
                               id="login"
                               type="text"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Email ">
                        @error('email')
                        <div class="mt-4 text-sm text-red ">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-16 flex justify-center">
                        <button class="border-2 border-blue transition text-sm
                                    text-center px-12 py-4 text-blue
                                    hover:text-gray-light hover:bg-blue"
                                type="submit">ОТПРАВИТЬ
                        </button>
                    </div>
                    @error('reset')
                    <div class="mt-10 text-sm text-red text-center">{{ $message }}</div>
                    @enderror
                </form>
            @else
                <div class="px-16 text-base text-green mt-8 tracking-wide">
                    Ссылка для восстановления отправлена на адрес {{ old('email') }}!
                </div>
            @endif
        </div>
    </div>
@endsection
