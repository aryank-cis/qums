<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('public/asset/logo/Companylogo.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'QMS') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<style>
    #app{
        height: 100vh !important;
        max-width: 100vw !important;
        /* margin-left: 250px; */
        padding: 20px;
    }
    .sidebarClose{
        margin-left: 250px !important;
    }
</style>

<body >
    <div id="app" class="">
        <main class="">
            @yield('content')
        </main>
    </div>
</body>
</html>
