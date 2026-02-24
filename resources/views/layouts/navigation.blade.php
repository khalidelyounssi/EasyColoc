<nav class="max-w-7xl mx-auto px-6 mt-6">
    <div class="bg-white rounded-[2rem] px-8 py-4 flex justify-between items-center shadow-sm border border-[#F5F5F7]">
        <div class="flex items-center space-x-4">
            <div class="w-10 h-10 bg-black rounded-2xl flex items-center justify-center text-white font-bold tracking-tighter italic">EC</div>
            <span class="text-xl font-bold text-[#1D1D1F] tracking-tight">EasyColoc</span>
        </div>
        
        <div class="hidden md:flex items-center space-x-8 text-sm font-bold text-gray-400">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-black' : '' }} hover:text-black transition">Dashboard</a>
            <a href="#" class="hover:text-black transition">Paiements</a>
        </div>

        <div class="flex items-center space-x-4 border-l pl-6 border-gray-100">
            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-xs font-bold text-gray-600 border border-gray-100">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <span class="text-xs font-bold text-gray-900">{{ Auth::user()->name }}</span>
        </div>
    </div>
</nav>