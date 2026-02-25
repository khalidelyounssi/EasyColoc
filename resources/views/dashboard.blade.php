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
                <h1 class="text-4xl font-bold tracking-tighter uppercase">Dashboard</h1>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">Status: Active Node</p>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 bg-white rounded-[2.5rem] p-12 border border-[#F5F5F7] shadow-sm flex flex-col justify-between min-h-[380px]">
                @if(isset($activeColocation))
                    <div>
                        <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest italic tracking-tighter">Space Active</span>
                        <h2 class="text-6xl font-black mt-6 tracking-tighter uppercase leading-none italic">
                            {{ $activeColocation->colocation->name }}
                        </h2>
                        <p class="mt-8 text-gray-400 font-medium leading-relaxed max-w-md">
                            "{{ Str::limit($activeColocation->colocation->description, 100) }}"
                        </p>
                    </div>
                    <div class="pt-8 border-t border-gray-50 flex justify-between items-center mt-10 italic">
                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Rôle: {{ $activeColocation->role }}</span>
                        <a href="{{ route('colocation.show', $activeColocation->colocation->id) }}" class="bg-black text-white px-10 py-4 rounded-full font-bold text-sm shadow-xl hover:scale-105 transition-all">
                            Ouvrir ➔
                        </a>
                    </div>
                @else
                    <div class="text-center py-10 flex flex-col items-center justify-center h-full">
                        <p class="text-gray-400 font-bold italic mb-6">Aucune coloc active.</p>
                        <a href="{{ route('colocation.create') }}" class="bg-black text-white px-10 py-4 rounded-full font-bold text-sm uppercase tracking-widest">Créer une coloc</a>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-4 bg-white rounded-[2.5rem] p-12 border border-[#F5F5F7] shadow-sm flex flex-col items-center justify-center text-center">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-10 italic tracking-widest">Reputation</h3>
                <span class="text-9xl font-black tracking-tighter text-black leading-none italic">
                    {{ auth()->user()->reputation_score }}
                </span>
                <p class="mt-10 text-[10px] font-bold text-indigo-500 uppercase tracking-widest italic tracking-widest">Statut: Trusted</p>
            </div>
        </div>
    </div>
</x-app-layout>