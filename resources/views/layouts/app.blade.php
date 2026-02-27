<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EasyColoc — Dashboard</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-[#1D1D1F]">
        <div class="flex min-h-screen bg-[#FAFAFA]">
            
            @include('layouts.navigation') 

            <main class="flex-1 ml-72">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>