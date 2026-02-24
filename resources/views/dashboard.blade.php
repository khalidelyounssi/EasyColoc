<x-app-layout>
    <div class="py-12 px-6 max-w-7xl mx-auto space-y-8 bg-[#FAFAFA] min-h-screen font-sans">
        
        <header class="flex justify-between items-end mb-4">
            <div>
                <h1 class="text-3xl font-bold text-[#1D1D1F] tracking-tight">Tableau de bord</h1>
                <p class="text-gray-400 text-sm font-medium mt-1">Gérez votre colocation en toute simplicité.</p>
            </div>
            <div class="text-right">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Session active</span>
                <span class="text-sm font-bold text-indigo-600">{{ Auth::user()->name }}</span>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <div class="lg:col-span-8 bg-white rounded-[2rem] p-10 border border-[#F5F5F7] shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between min-h-[350px]">
                @if($activeColocation)
                    <div>
                        <div class="flex items-center space-x-2 mb-6">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Espace Actuel</span>
                        </div>
                        <h2 class="text-5xl font-bold text-[#1D1D1F] tracking-tighter leading-tight">
                            {{ $activeColocation->colocation->name }}
                        </h2>
                        <p class="mt-6 text-gray-500 font-medium leading-relaxed max-w-lg">
                            {{ Str::limit($activeColocation->colocation->description, 140) }}
                        </p>
                    </div>
                    
                    <div class="pt-8 border-t border-gray-50 flex justify-between items-center mt-8">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-bold text-gray-400">Rôle :</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full text-[10px] font-bold text-gray-600 uppercase">{{ $activeColocation->role }}</span>
                        </div>
                        <a href="{{ route('colocation.show', $activeColocation->colocation->id) }}" 
                           class="bg-gray-900 text-white px-8 py-3 rounded-full font-bold text-sm hover:bg-black transition-all shadow-lg shadow-gray-200">
                           Ouvrir l'espace
                        </a>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-center">
                        <p class="text-gray-400 font-medium mb-6">Aucune colocation active.</p>
                        <a href="{{ route('colocation.create') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-full font-bold text-sm">Créer une coloc</a>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-4 bg-white rounded-[2rem] p-10 border border-[#F5F5F7] shadow-sm flex flex-col items-center justify-center text-center">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-12">Ma Réputation</h3>
                <div class="relative">
                    <span class="text-9xl font-bold text-[#1D1D1F] tracking-tighter">{{ auth()->user()->reputation_score }}</span>
                    <div class="absolute -top-4 -right-4 bg-[#FFD60A] w-10 h-10 rounded-full flex items-center justify-center text-white shadow-sm font-bold text-xl">★</div>
                </div>
                <p class="mt-12 text-xs font-bold text-indigo-500 bg-indigo-50 px-4 py-2 rounded-full uppercase tracking-widest">Membre de confiance</p>
            </div>

            <div class="lg:col-span-12 bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-xl font-bold text-[#1D1D1F]">Activités récentes</h3>
                    <button class="text-gray-400 font-bold text-xs uppercase hover:text-black tracking-widest">Tout voir</button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @if($activeColocation && $activeColocation->colocation->expenses->count() > 0)
                        @foreach($activeColocation->colocation->expenses->take(4) as $expense)
                            <div class="bg-[#FAFAFA] p-6 rounded-3xl border border-gray-100 hover:border-indigo-100 transition-colors group">
                                <div class="w-10 h-10 bg-white rounded-2xl flex items-center justify-center text-lg shadow-sm mb-4 group-hover:scale-110 transition-transform">🛒</div>
                                <p class="font-bold text-gray-900 truncate mb-1">{{ $expense->title }}</p>
                                <div class="flex justify-between items-end">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Par {{ $expense->user->name }}</span>
                                    <span class="font-bold text-lg text-gray-900">{{ number_format($expense->amount, 0) }} <span class="text-[10px] text-gray-400">DH</span></span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="lg:col-span-4 py-10 text-center text-gray-300 font-medium italic">Aucune dépense enregistrée.</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>