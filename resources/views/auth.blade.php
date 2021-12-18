<?php

/**
 * @author Mark Prohorov <mark.proxorofff@gmail.com>
 */
?>

@extends('layouts.auth')

@section('content')
    <div class="flex flex-col h-100%">
        <div class="flex justify-between px-6 py-8 bg-oceanic">
            <div class="font-medium tracking-wide text-xl text-gray-light">
                Отдел кадров
            </div>
            <div>
                <a href="/" class="
            p-2 rounded transition text-sm text-gray-light
            hover:bg-oceanic-light hover:text-blue">
                    Авторизация
                </a>
            </div>
        </div>
        <div class="flex justify-center items-center grow">
            <div class="max-w-xl bg-oceanic py-12 w-96">
                <div class="border-l-2 border-blue px-16 flex items-center justify-between h-12">
                    <span class="text-gray-light font-bold">ВХОД</span>
                    <a href="/" class="text-gray text-sm transition hover:text-gray-light">забыли пароль?</a>
                </div>

                <div class="auth-form-body">

                    <form class="px-16" action="" method="post">
                        <div class="mt-12 ">
                            <input class="
                                bg-oceanic pt-3 pb-2 text-gray-light
                                border-b border-gray-light text-base @error('password') border-red @enderror
                            " id="login" type="text" name="login" value="" placeholder="Логин">
                            @error('login')
                            <div class="mt-4 text-sm text-red ">Заполните логин</div>
                            @enderror
                        </div>

                        <div class="mt-12">
                            <input class="
                                bg-oceanic pt-3 pb-2 text-gray-light
                                border-b border-gray-light text-base @error('password') border-red @enderror
                            " id="password" type="password" name="password" placeholder="Пароль">
                            @error('password')
                            <div class="mt-4 text-sm text-red ">Заполните пароль</div>
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

                        @error('server')
                        <div class="mt-10 text-sm text-red text-center">Ошибка сервера, повторите позднее</div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
