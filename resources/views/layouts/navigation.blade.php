<aside class="fixed left-0 top-0 h-screen w-72 bg-white border-r border-[#F5F5F7] p-8 flex flex-col justify-between shadow-sm z-50">
    <div class="space-y-12">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group px-2">
            <div class="w-12 h-12 bg-black rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-all">
                <span class="text-white font-bold italic text-2xl">E</span>
            </div>
            <span class="text-2xl font-black tracking-tighter text-[#1D1D1F]">EasyColoc</span>
        </a>

        <nav class="space-y-2">
            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em] px-4 mb-4 block italic">Menu Principal</span>
            
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-4 px-4 py-4 rounded-3xl transition-all {{ request()->routeIs('dashboard') ? 'bg-black text-white shadow-xl italic' : 'text-gray-400 hover:bg-gray-50 hover:text-black' }}">
                <span class="text-xl">🏠</span>
                <span class="text-sm font-bold uppercase tracking-widest">Dashboard</span>
            </a>

            @if(Auth::user()->is_admin)
                <span class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em] px-4 mt-8 mb-4 block italic">Administration</span>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-4 px-4 py-4 rounded-3xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-xl italic' : 'text-gray-400 hover:bg-indigo-50 hover:text-indigo-600' }}">
                    <span class="text-xl">🛡️</span>
                    <span class="text-sm font-bold uppercase tracking-widest">Gestion Globale</span>
                </a>
            @endif

            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em] px-4 mt-8 mb-4 block italic">Utilisateur</span>
            <a href="#" class="flex items-center space-x-4 px-4 py-4 rounded-3xl text-gray-400 hover:bg-gray-50 hover:text-black transition-all">
                <span class="text-xl">📊</span>
                <span class="text-sm font-bold uppercase tracking-widest">Dépenses</span>
            </a>
        </nav>
    </div>

    <div class="pt-8 border-t border-gray-50 space-y-6">
        <div class="px-4">
            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest block mb-1">Session</span>
            <p class="text-sm font-black text-black italic truncate">{{ Auth::user()->name }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-red-50 text-red-600 p-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest border border-red-100 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                Déconnexion
            </button>
        </form>
    </div>
</aside>