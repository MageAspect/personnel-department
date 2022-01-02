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
            <div class="ml-4 tracking-wider flex items-center">
                <div class="mr-2">Редактирование:</div>
                <input type="text"
                       class="text-xl leading-5 bg-unset border border-blue-dark pt-1 px-1.25 pb-1.25 font-light"
                       value="Бухгалтерия">
            </div>
        </div>
        <div class="flex">
            <a href="/" class="btn btn-light mr-4">
                <span>К списку</span>
            </a>
            <a href="/" class="btn btn-success">
                <span>Сохранить</span>
            </a>
        </div>
    </div>
    <div class="p-6 pb-0">
        <div class="bg-oceanic-light p-6">
            <div class="flex mb-6">
                <div class="tracking-wider text-gray-light text-xl mr-3">Руководитель отдела</div>
                <div class="btn btn-light-success">Изменить</div>
            </div>
            <div class="pb-6 border-b border-oceanic-lighter">
                <div class="flex">
                    <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                        <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                             style="background-image: url('/img/user/user.jpg');"></div>
                    </div>
                    <div class="ml-4 font-medium">
                        <a href="/" class="mb-1 link-gray-light text-base">Станислав Башкиров</a>
                        <div class="text-gray text-xs">Генеральный директор</div>
                    </div>
                    <div class="font-medium ml-18">
                        <div class="mb-1 text-gray-lighter text-sm">Телефон:</div>
                        <div class="mb-1 text-gray-lighter text-sm">Email:</div>
                    </div>
                    <div class="font-medium ml-18">
                        <div class="mb-1 text-gray-lighter text-sm">8 (555) 444 27-54</div>
                        <div class="mb-1 text-gray-lighter text-sm">jeckich@mosowell.ru</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-oceanic-light p-6 mt-6">
            <div class="tracking-wider flex items-center text-gray-light text-xl mb-6">Описание</div>
            <textarea rows="4" class="p-3 text-gray bg-unset border border-blue-dark w-full ui-y-scroll"></textarea>
        </div>

        <div class="bg-oceanic-light p-6 pb-0 mt-6">
            <div class="flex">
                <div class="mr-2 tracking-wider text-gray-light text-xl">Сотрудники (1)</div>
                <div class="btn btn-light-add">
                    <i class="mr-1 fas fa-plus"></i>
                    <span class="">Добавить</span>
                </div>
            </div>
            <div class="grid grid-col-users-list gap-y-6 py-6">
                <user-preview-in-grid :id="34"
                                      name="Станислав"
                                      last-name="Башкиров"
                                      position="Генеральный директор"
                                      phone="8 (555) 444 27-54"
                                      email="bash@mosowell.ru"
                                      profile-link="/123/"
                                      avatar-path="/img/user/user.jpg"
                                      action-button-text="Удалить"
                                      action-button-class="btn-light-delete"
                ></user-preview-in-grid>
            </div>
        </div>
    </div>
    <user-selector-popup>

    </user-selector-popup>
@endsection

