<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body,
            html {
                margin: 0;
                padding: 0;
            }
        
            .bg-login {
                background: url("{{ asset('images/bg.jpg') }}") no-repeat center center fixed;
                background-size: cover;
                /* Phủ kín toàn màn hình */
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                /* Nếu cần chữ màu trắng để nổi bật hơn */
            }
        </style>
        
    </head>
    <body class="font-sans text-gray-900 antialiased bg-login">
        <div class="flex flex-col sm:justify-center items-center sm:pt-0 bg-gray-100 rounded">

            <div class="sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" style="width: 500px">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
