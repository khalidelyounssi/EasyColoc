<x-app-layout>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <div class="py-12 px-12 max-w-7xl mx-auto space-y-10">

        @if(isset($pendingInvitations) && $pendingInvitations->count() > 0)
            <div class="space-y-4">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] ml-2 italic">Invitations en
                    attente</span>
                @foreach($pendingInvitations as $invitation)
                    <div
                        class="bg-white border border-yellow-100 p-8 rounded-[2.5rem] shadow-sm flex justify-between items-center group hover:border-yellow-200 transition-all">
                        <div class="flex items-center space-x-6">
                            <div
                                class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                                📩</div>
                            <div>
                                <p class="font-bold text-xl tracking-tight">Nouvelle invitation !</p>
                                <p class="text-xs font-medium text-gray-500 italic">Rejoins <span
                                        class="text-black font-black uppercase">{{ $invitation->colocation->name }}</span></p>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <form action="{{ route('invitations.accept', $invitation->token) }}" method="get">
                                @csrf
                                <button type="submit"
                                    class="bg-black text-white px-10 py-4 rounded-full font-bold text-xs uppercase tracking-widest shadow-lg italic">Accepter</button>
                            </form>
                            <form action="{{ route('invitations.reject', $invitation->token) }}" method="get">
                                @csrf
                                <button type="submit"
                                    class="bg-gray-50 text-gray-400 px-10 py-4 rounded-full font-bold text-xs uppercase tracking-widest italic">Refuser</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="space-y-12">

            <div class="space-y-6">
                <header class="mb-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-5xl font-black tracking-tighter uppercase italic leading-none">Dashboard</h1>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-2">Node: Active</p>
                    </div>
                    <a href="{{ route('colocation.create') }}"
                        class="bg-black text-white px-10 py-4 rounded-full font-bold text-xs uppercase tracking-widest shadow-lg italic hover:scale-105 transition-all">+
                        Créer</a>
                </header>

                <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest italic ml-4">Tes Espaces
                    Actifs</span>

                @forelse($activeColocations as $membership)
                    <div
                        class="bg-white rounded-[3rem] p-10 border border-[#F5F5F7] shadow-sm flex flex-col md:flex-row justify-between items-center gap-6 group hover:border-indigo-100 transition-all">
                        <div class="flex-1">
                            <h2 class="text-4xl font-black tracking-tighter uppercase italic leading-none mb-4">
                                {{ $membership->colocation->name }}</h2>
                            <p class="text-gray-400 font-medium text-sm italic">
                                {{ Str::limit($membership->colocation->description, 100) }}</p>
                        </div>
                        <a href="{{ route('colocation.show', $membership->colocation->id) }}"
                            class="bg-black text-white px-10 py-4 rounded-full font-bold text-sm shadow-xl hover:scale-105 transition-all uppercase tracking-widest italic shrink-0">Ouvrir
                            ➔</a>
                    </div>
                @empty
                    <div class="bg-white rounded-[3rem] p-12 border border-dashed border-gray-200 text-center">
                        <p class="text-gray-400 font-bold italic uppercase tracking-widest text-[10px]">Aucune colocation
                            active.</p>
                    </div>
                @endforelse
            </div>

            <div class="pt-10 space-y-8">
                <div class="px-4 border-l-4 border-black">
                    <h3 class="text-3xl font-black italic uppercase tracking-tighter leading-none">Registry</h3>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Global Community Trust
                        Scores</p>
                </div>

                <div class="flex overflow-x-auto pb-8 gap-6 snap-x no-scrollbar">
                    @foreach($allUsers as $u)
                        <div
                            class="min-w-[18rem] bg-white border border-[#F5F5F7] p-8 rounded-[2.5rem] flex flex-col items-center group hover:shadow-xl transition-all snap-center">
                            <div
                                class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-xl mb-4 shadow-inner">
                                👤</div>
                            <p class="font-black text-sm uppercase italic leading-none mb-1">{{ $u->name }}</p>
                            <p class="text-[8px] font-bold text-gray-300 uppercase tracking-widest mb-6">
                                {{ Str::limit($u->email, 20) }}</p>

                            <div class="w-full py-6 bg-gray-50/50 rounded-2xl text-center border border-gray-100 italic">
                                <span class="text-[8px] font-bold text-gray-400 uppercase tracking-[0.2em]">Reputation
                                    Score</span>
                                <p
                                    class="text-4xl font-black mt-2 tracking-tighter {{ $u->reputation_score >= 0 ? 'text-black' : 'text-red-500' }}">
                                    {{ $u->reputation_score ?? 0 }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>



            @if(isset($historyColocations) && $historyColocations->count() > 0)
                <div class="pt-10 space-y-6">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic ml-4">Archives &
                        Historique</span>
                    <div class="space-y-4">
                        @foreach($historyColocations as $history)
                            <div
                                class="bg-white/50 border border-gray-100 p-8 rounded-[2.5rem] flex justify-between items-center opacity-60 hover:opacity-100 transition-all grayscale hover:grayscale-0">
                                <div class="flex items-center space-x-6">
                                    <div
                                        class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-xl shadow-inner italic">
                                        🏛️</div>
                                    <div>
                                        <p class="font-black text-gray-600 italic uppercase leading-none">
                                            {{ $history->colocation->name }}</p>
                                        <p class="text-[9px] font-bold text-gray-400 uppercase italic mt-2">Quittée le :
                                            {{ \Carbon\Carbon::parse($history->left_at)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('colocation.show', $history->colocation->id) }}"
                                    class="text-black font-black text-[10px] uppercase tracking-widest hover:underline italic">Voir
                                    ➔</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>