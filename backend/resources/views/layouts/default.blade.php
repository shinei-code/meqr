<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="{{asset('img/logo-sm.png')}}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('styles/style.css') }}" rel="stylesheet">
</head>
<body class="h-100">
    @include('components.header')
    <div class="d-flex flex-row w-100 content">

    <div class="d-flex flex-row w-100 content">
    @if(!Auth::guest())
        @include('components.side-menu')
    @endif

        <!-- メインコンテンツ -->
            <main class="w-100 mx-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
    </div>
</body>
</html>
