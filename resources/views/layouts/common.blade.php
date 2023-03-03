<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- App Name --}}
    <title>{{ config('app.name', 'Larawide') }}</title>
    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <title>Document</title>
</head>

<body>
<div>
        @yield('header')
    </div>
    <div class="flex">
        <div class="w-1/6">
            @yield('sidebar')
        </div>
        <main class="w-full">
            @yield('content')
        </main>
    </div>
    <div>
        @yield('footer')
    </div>
</body>

</html>