<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        @font-face {
            font-family: "testFont";
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/F3BAUJM3.ttf') }}");
        }
        body{
            font-family: 'testFont';
        }
        .page-break {
            page-break-after: always;
        }
        table {
            border-collapse: collapse;
        }

        tr {
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid black;
        }    </style>
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
