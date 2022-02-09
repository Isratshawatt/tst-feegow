<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS Template -->
    <link rel="stylesheet" href="{{ mix('/css/template.min.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/custom.min.css') }}">

    <title>Feegow</title>

    @stack('scripts-css')

    <style>
        
    </style>
</head>

<body>
    @include('layouts.navigation')
    <!-- Page Heading -->
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                {{ $header }}
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Template js -->
    <script src="{{ mix('/js/template.min.js') }}" type="text/javascript"></script>
    @stack('scripts-js')
</body>

</html>