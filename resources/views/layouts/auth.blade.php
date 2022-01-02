<?php
/**
 * @author mosowell https://github.com/mosowell
 */
?>

    <!doctype html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}" class="text-html-base bg-oceanic-light h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body class="font-sans h-full">
<div id="app" class="h-full">
    <div class="flex flex-col h-full">
        <div class="flex justify-between px-5 py-4 bg-oceanic">
            <div class="py-2 font-medium tracking-wide text-xl text-gray-light">
                Отдел кадров
            </div>
            <x-auth-menu></x-auth-menu>
        </div>
        @yield('content')
    </div>
</div>

<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
