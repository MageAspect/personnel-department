<?php

/**
 * @author mosowell https://github.com/mosowell
 */
?>

<div class="bg-oceanic basis-68 shrink-0">
    <div class="pt-8 px-5 pb-5 border-b border-oceanic-light">
        <div class="w-12 h-12 rounded-50% overflow-hidden">
            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                 style="background-image: url('/img/user/user.jpg');"></div>
        </div>
        <div class="mt-5">
            <a href="/users/12/details/" class="text-gray-light text-xl font-medium">
                Прохоров Марк
            </a>
        </div>
    </div>
    <div class="px-3 pb-5">
        <div class="border-b border-oceanic-light py-3">
            <div class="pl-2 text-gray-light text-gray-dark opacity-50 text-3.5">Главное меню</div>
            <a href="{{ route('departments.index') }}" class="p-2 mt-3 flex items-center rounded
                                        text-gray-dark text-sm font-medium transition
                                        hover:bg-oceanic-light hover:text-blue">
                <div class="shrink-0 mr-5">
                         <i class="fas fa-layer-group"></i>
                </div>
                <div class="">Отделы</div>
            </a>
            <a href="{{ route('users.index') }}" class="p-2 mt-3 flex items-center rounded
                                        text-gray-dark text-sm font-medium transition
                                        hover:bg-oceanic-light hover:text-blue">
                <div class="shrink-0 mr-5">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="">Сотрудники</div>
            </a>
        </div>
        <div class="py-3">
            <div class="text-gray-light text-gray-dark opacity-50 text-3.5">Управление аккаунтом</div>
            <a href="/departments/" class="p-2 mt-3 flex items-center rounded
                                        text-gray-dark text-sm font-medium transition
                                        hover:bg-oceanic-light hover:text-blue">
                <div class="shrink-0 mr-5">
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="">Настройки</div>
            </a>
            <a href="{{ route('auth.logout') }}" class="p-2 mt-3 flex items-center rounded
                                        text-gray-dark text-sm font-medium transition
                                        hover:bg-oceanic-light hover:text-blue">
                <div class="shrink-0 mr-5">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <div class="">Выйти</div>
            </a>
        </div>
    </div>
</div>
