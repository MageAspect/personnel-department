<?php

/**
 * @author mosowell https://github.com/mosowell
 */
?>

@extends('layouts.app')

@section('content')
    <div class="flex justify-between pb-5 px-6 border-b border-oceanic-light">
        <div class="flex text-gray-light font-light text-xl items-center">
            <i class="text-gray-dark fas fa-layer-group"></i>
            <div class="ml-4 tracking-wider">Список отделов</div>
        </div>
        <div>
            <a href="/" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Добавить</span>
            </a>
        </div>
    </div>
    <div class="grid p-6 grid-cols-departments gap-7">
        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>
        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero ma
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>

        <div class="border-oceanic-light border flex flex-col justify-between">
            <div class="p-4">
                <a href="/"
                   class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">Отдел
                    Продаж</a>
                <div class="my-5">
                    <div class="flex">
                        <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                            <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                                 style="background-image: url('/img/user/user.jpg');"></div>
                        </div>
                        <div class="ml-4 font-medium">
                            <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                            <div class="text-gray text-xs">Генеральный директор</div>
                        </div>
                    </div>
                </div>
                <div class="text-base leading-5 text-gray-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias
                    atque earum est ex id iusto, libero magni neque non odio, placeat, quibusdam quos temporibus!sto, libero
                    magni neque non odio, placeat, quibusdam quos temporibus!sto, libero magni neque non odio, placeat,
                    quibusdam quos temporodio, placeat, quibusdam quos temporibus!
                </div>
            </div>
            <div class="bg-oceanic-light p-1 flex justify-between text-2xs text-white ">
                <button class="p-2 uppercase font-medium hover:text-green transition">редактировать</button>
                <button class="p-2 uppercase font-medium hover:text-red transition">Удалить</i></button>
            </div>
        </div>


    </div>
@endsection
