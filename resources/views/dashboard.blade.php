<x-app-layout>
    <div class="flex min-h-screen bg-[#FAFAFA] font-sans antialiased text-[#1D1D1F]">
        
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

        <main class="flex-1 ml-72">
            <div class="py-12 px-12 max-w-7xl mx-auto space-y-8">
                
                @if(isset($pendingInvitations) && $pendingInvitations->count() > 0)
                    <div class="space-y-4 mb-10">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] ml-2 italic">Invitations en attente</span>
                        @foreach($pendingInvitations as $invitation)
                            <div class="bg-white border border-yellow-100 p-6 rounded-[2rem] shadow-sm flex justify-between items-center group hover:border-yellow-200 transition-all">
                                <div class="flex items-center space-x-5">
                                    <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-xl">📩</div>
                                    <div>
                                        <p class="font-bold text-lg tracking-tight">Nouvelle invitation !</p>
                                        <p class="text-xs font-medium text-gray-500">Tu as été invité à rejoindre <span class="text-black font-black uppercase italic">{{ $invitation->colocation->name }}</span></p>
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <a href="{{ route('invitations.accept', $invitation->token) }}" class="bg-black text-white px-8 py-3 rounded-full font-bold text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-lg italic">Accepter</a>
                                    <a href="{{ route('invitations.reject', $invitation->token) }}" class="bg-gray-50 text-gray-400 px-8 py-3 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-red-50 hover:text-red-500 transition-all italic">Refuser</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <header class="flex justify-between items-end mb-4">
                    <div>
                        <h1 class="text-4xl font-bold tracking-tighter uppercase italic">Dashboard</h1>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Status: Active Node</p>
                    </div>
                </header>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-8 space-y-6">
                        <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest italic ml-4">Spaces Actifs</span>
                        
                        @forelse($activeColocations as $membership)
                            <div class="bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm flex flex-col md:flex-row justify-between items-center gap-6 group hover:border-indigo-50 transition-all">
                                <div class="flex-1">
                                    <h2 class="text-4xl font-black tracking-tighter uppercase leading-none italic mb-4">{{ $membership->colocation->name }}</h2>
                                    <p class="text-gray-400 font-medium text-sm italic">{{ Str::limit($membership->colocation->description, 80) }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-4">
                                    <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Rôle: {{ $membership->role }}</span>
                                    <a href="{{ route('colocation.show', $membership->colocation->id) }}" class="bg-black text-white px-10 py-4 rounded-full font-bold text-sm shadow-xl hover:scale-105 transition-all shrink-0">Ouvrir ➔</a>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-[2.5rem] p-12 border border-dashed border-gray-200 text-center flex flex-col items-center justify-center min-h-[300px]">
                                <p class="text-gray-400 font-bold italic">Aucune coloc active.</p>
                                <a href="{{ route('colocation.create') }}" class="mt-6 bg-black text-white px-10 py-4 rounded-full font-bold text-xs uppercase tracking-widest inline-block">+ Créer</a>
                            </div>
                        @endforelse

                        @if(isset($historyColocations) && $historyColocations->count() > 0)
                            <div class="pt-10">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic ml-4">Archives / Historique</span>
                                <div class="mt-4 space-y-4">
                                    @foreach($historyColocations as $history)
                                        <div class="bg-white/50 border border-gray-100 p-6 rounded-[2rem] flex justify-between items-center opacity-60 hover:opacity-100 transition-opacity grayscale hover:grayscale-0">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-sm">🏛️</div>
                                                <div>
                                                    <p class="font-bold text-gray-600 italic">{{ $history->colocation->name }}</p>
                                                    <p class="text-[9px] font-bold text-gray-400 uppercase italic">Quittée le: {{ \Carbon\Carbon::parse($history->left_at)->format('d M Y') }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('colocation.show', $history->colocation->id) }}" class="text-black font-bold text-[10px] uppercase tracking-widest hover:underline italic">Voir</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-white rounded-[2.5rem] p-12 border border-[#F5F5F7] shadow-sm flex flex-col items-center justify-center text-center sticky top-12">
                            <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-10 italic">Reputation</h3>
                            <span class="text-9xl font-black tracking-tighter text-black leading-none italic">
                                {{ auth()->user()->reputation_score ?? '0' }}
                            </span>
                            <p class="mt-10 text-[10px] font-bold text-indigo-500 uppercase tracking-widest italic">Statut: Trusted</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>