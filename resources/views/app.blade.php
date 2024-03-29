<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'COD Investor') }}</title>

        <link rel="icon" type="image/svg+xml" href="{{ \App\Models\Websetting::first()->icon }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('app.css') }}">
        <!-- Scripts -->
        {{-- font awesome --}}
        <script src="https://kit.fontawesome.com/276305b3f3.js" crossorigin="anonymous"></script>
        {{-- sweetalert --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @routes
        @vite('resources/js/app.js')
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
      <!-- Google tag (gtag.js) -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11391713151"></script>
        @inertia
    </body>
</html>
