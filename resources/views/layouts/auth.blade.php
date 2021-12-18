<?php
/**
 * @author Mark Prohorov <mark.proxorofff@gmail.com>
 */
?>

    <!doctype html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}" class="text-html-base bg-oceanic-light h-full-screen">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="font-sans h-100%">
<div id="app" class="h-100%">
    @yield('content')
</div>

<script src="/js/app.js"></script>
</body>
</html>