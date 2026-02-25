<x-app-layout>
    <div class="py-12 px-6 max-w-7xl mx-auto space-y-8 bg-[#FAFAFA] min-h-screen font-sans antialiased text-[#1D1D1F]">
        
        @if(isset($pendingInvitations) && $pendingInvitations->count() > 0)
            <div class="space-y-4 mb-10">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] ml-2 italic">Invitations en attente</span>
                @foreach($pendingInvitations as $invitation)
                    <div class="bg-white border border-yellow-100 p-6 rounded-[2rem] shadow-sm flex justify-between items-center group hover:border-yellow-200 transition-all">
                        <div class="flex items-center space-x-5">
                            <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-xl">📩</div>
                            <div>
                                <p class="font-bold text-lg tracking-tight">Nouvelle invitation !</p>
                                <p class="text-xs font-medium text-gray-500">Tu as été invité à rejoindre <span class="text-black font-black uppercase">{{ $invitation->colocation->name }}</span></p>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('invitations.accept', $invitation->token) }}" class="bg-black text-white px-8 py-3 rounded-full font-bold text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-lg">
                                Accepter
                            </a>
                            <a href="{{ route('invitations.reject', $invitation->token) }}" class="bg-gray-50 text-gray-400 px-8 py-3 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-red-50 hover:text-red-500 transition-all">
                                Refuser
                            </a>
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
                    <div class="bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex-1">
                            <h2 class="text-4xl font-black tracking-tighter uppercase leading-none italic mb-4">
                                {{ $membership->colocation->name }}
                            </h2>
                            <p class="text-gray-400 font-medium text-sm italic">{{ Str::limit($membership->colocation->description, 80) }}</p>
                        </div>
                        <div class="flex flex-col items-end gap-4">
                            <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Rôle: {{ $membership->role }}</span>
                            <a href="{{ route('colocation.show', $membership->colocation->id) }}" class="bg-black text-white px-10 py-4 rounded-full font-bold text-sm shadow-xl hover:scale-105 transition-all shrink-0">
                                Ouvrir ➔
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-[2.5rem] p-12 border border-dashed border-gray-200 text-center flex flex-col items-center justify-center min-h-[300px]">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-2xl mb-6">🏠</div>
                        <p class="text-gray-400 font-bold italic mb-8">Vous n'avez aucune colocation active pour le moment.</p>
                        <a href="{{ route('colocation.create') }}" class="bg-black text-white px-10 py-5 rounded-full font-bold text-xs uppercase tracking-widest shadow-xl hover:scale-105 transition-all">
                            + Créer ma première colocation
                        </a>
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
                                            <p class="font-bold text-gray-600">{{ $history->colocation->name }}</p>
                                            <p class="text-[9px] font-bold text-gray-400 uppercase italic">
                                                Quittée le: {{ \Carbon\Carbon::parse($history->left_at)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ route('colocation.show', $history->colocation->id) }}" class="text-black font-bold text-[10px] uppercase tracking-widest hover:underline decoration-2">
                                        Voir archives
                                    </a>
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
</x-app-layout>