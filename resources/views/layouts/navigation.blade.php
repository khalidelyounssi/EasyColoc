<nav x-data="{ open: false }" class="max-w-7xl mx-auto px-6 mt-6 font-sans antialiased">
    <div class="bg-white rounded-[2rem] px-10 py-5 flex justify-between items-center shadow-sm border border-[#F5F5F7]">
        
        <div class="flex items-center shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 bg-black rounded-2xl flex items-center justify-center shadow-lg shadow-black/10 group-hover:scale-105 transition-all">
                    <span class="text-white font-bold italic text-xl leading-none">E</span>
                </div>
                <span class="text-2xl font-bold tracking-tighter text-[#1D1D1F]">EasyColoc</span>
            </a>
        </div>

        <div class="hidden sm:flex items-center space-x-12">
            <a href="{{ route('dashboard') }}" 
               class="text-sm font-bold uppercase tracking-widest transition-colors {{ request()->routeIs('dashboard') ? 'text-black' : 'text-gray-400 hover:text-black' }}">
                Dashboard
            </a>
            
            <a href="#" class="text-gray-400 text-sm font-bold hover:text-black transition-colors uppercase tracking-widest">
                Dépenses
            </a>
            
            <a href="#" class="text-gray-400 text-sm font-bold hover:text-black transition-colors uppercase tracking-widest">
                Membres
            </a>
        </div>

        <div class="hidden sm:flex items-center space-x-6">
            <div class="flex flex-col items-end border-r pr-6 border-gray-100 text-right">
                <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest leading-none mb-1">Session</span>
                <span class="text-xs font-bold text-black">{{ Auth::user()->name }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-50 text-red-600 px-6 py-2.5 rounded-full text-[10px] font-bold uppercase tracking-widest border border-red-100 shadow-sm hover:bg-red-600 hover:text-white transition-all">
                    Déconnexion
                </button>
            </form>
        </div>

        <div class="flex items-center sm:hidden">
            <button @click="open = ! open" class="p-3 rounded-2xl text-gray-400 bg-gray-50 hover:text-black transition-all">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden mt-4">
        <div class="bg-white rounded-[2rem] p-8 shadow-xl border border-gray-100 space-y-6 text-center">
            <a href="{{ route('dashboard') }}" class="block font-bold {{ request()->routeIs('dashboard') ? 'text-black' : 'text-gray-400' }}">Dashboard</a>
            <a href="#" class="block font-bold text-gray-400">Dépenses</a>
            
            <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-gray-50">
                @csrf
                <button type="submit" class="text-red-600 font-bold uppercase text-xs tracking-widest">Se déconnecter</button>
            </form>
        </div>
    </div>
</nav>