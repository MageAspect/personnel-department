<?php
/**
 * @author MageAspect https://github.com/mageaspect
 */
?>

    <!doctype html>
<html class="h-full" lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=cyrillic"
          rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="icon" href="/img/favicon.ico" type="image/x-icon" />
</head>
<body class="font-sans h-full">
<div  class="h-full">
    <div class="flex  h-full bg-oceanic-light">
        <x-app-sidebar></x-app-sidebar>
        <div id="app" class=" ml-7 h-full bg-oceanic grow py-5 ui-y-scroll">
            @yield('content')
        </div>
    </div>
</div>
<script src="https://kit.fontawesome.com/c2de66263d.js" crossorigin="anonymous"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
