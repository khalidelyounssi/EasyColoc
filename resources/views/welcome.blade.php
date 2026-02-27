<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EasyColoc — Simplify your living</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-[#FAFAFA] text-[#1D1D1F] font-sans overflow-hidden">
        
        <div class="relative min-h-screen flex items-center justify-center p-6">
            
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-gray-200/50 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-indigo-50/50 blur-[100px] rounded-full"></div>

            <div class="relative z-10 w-full max-w-4xl text-center space-y-12">
                
                <div class="w-24 h-24 bg-black rounded-[2rem] flex items-center justify-center mx-auto shadow-2xl hover:scale-105 transition-transform duration-500">
                    <span class="text-white font-bold italic text-5xl">E</span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-7xl md:text-9xl font-black tracking-tighter uppercase italic leading-[0.8] mb-4">
                        Easy<br><span class="text-indigo-600">Coloc</span>
                    </h1>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.5em] italic">
                        The ultimate management tool for shared spaces
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-10">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-black text-white px-12 py-6 rounded-full font-bold text-sm shadow-xl hover:scale-105 transition-all uppercase tracking-widest italic">
                                Accéder au Dashboard ➔
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-black text-white px-12 py-6 rounded-full font-bold text-sm shadow-xl hover:scale-105 transition-all uppercase tracking-widest italic">
                                Se Connecter
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-white text-black border border-gray-100 px-12 py-6 rounded-full font-bold text-sm shadow-sm hover:bg-gray-50 transition-all uppercase tracking-widest italic">
                                    Rejoindre l'aventure
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <div class="pt-20">
                    <span class="text-[8px] font-black text-gray-300 uppercase tracking-[0.3em] italic">
                        © 2026 EasyColoc Node. All rights reserved.
                    </span>
                </div>
            </div>
        </div>
    </body>
</html>