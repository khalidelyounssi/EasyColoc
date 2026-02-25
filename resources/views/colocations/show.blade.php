<x-app-layout>
    <div class="py-12 px-6 max-w-7xl mx-auto space-y-8 bg-[#FAFAFA] min-h-screen font-sans antialiased">
        
        <header class="bg-white rounded-[2rem] p-10 border border-[#F5F5F7] shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-2 block italic">Espace de vie</span>
                <h1 class="text-5xl font-bold text-[#1D1D1F] tracking-tighter leading-tight italic">{{ $colocation->name }}</h1>
                <p class="text-gray-500 font-medium mt-4 max-w-xl italic">{{ $colocation->description }}</p>
            </div>
            <button onclick="document.getElementById('expenseModal').classList.remove('hidden')" 
                class="bg-black text-white px-10 py-5 rounded-full font-bold text-sm shadow-xl hover:scale-105 transition-all shrink-0 uppercase tracking-widest">
                + Ajouter une dépense
            </button>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm">
                    <h3 class="text-xl font-bold text-[#1D1D1F] italic uppercase tracking-tighter mb-10">Historique des transactions</h3>
                    <div class="space-y-6">
                        @forelse($colocation->expenses->sortByDesc('spent_at') as $expense)
                            <div class="flex items-center justify-between p-6 hover:bg-[#FAFAFA] rounded-3xl transition-colors group border border-transparent hover:border-gray-100">
                                <div class="flex items-center space-x-6">
                                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-gray-50 group-hover:scale-110 transition-transform">🛒</div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-lg tracking-tight">{{ $expense->title }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1 italic">{{ $expense->user->name ?? 'Membre' }} • {{ \Carbon\Carbon::parse($expense->spent_at)->format('d M') }}</p>
                                    </div>
                                </div>
                                <span class="text-2xl font-bold text-[#1D1D1F] tracking-tighter">{{ number_format($expense->amount, 0) }} <span class="text-xs text-gray-400 font-bold uppercase">DH</span></span>
                            </div>
                        @empty
                            <div class="text-center py-20 opacity-30 font-bold italic">Aucune dépense.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm">
                    <h3 class="text-xl font-bold text-[#1D1D1F] italic uppercase tracking-tighter mb-10">Récapitulatif des comptes</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($summary as $debt)
                            <div class="bg-[#FAFAFA] p-6 rounded-3xl flex flex-col justify-between border border-transparent hover:border-gray-100 transition-all group">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 italic">Doit payer</span>
                                        <span class="font-bold text-black italic">{{ $debt->sender->name }}</span>
                                    </div>
                                    <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center shadow-sm">➔</div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 italic">À</span>
                                        <span class="font-bold text-black italic">{{ $debt->receiver->name }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-end pt-4 border-t border-white">
                                    <span class="text-2xl font-black tracking-tighter italic">{{ number_format($debt->total, 0) }} <span class="text-xs text-gray-400 uppercase italic">DH</span></span>
                                    
                                    @if(auth()->id() === $debt->sender_id)
                                        <form action="{{ route('settlements.pay_all', [$colocation->id, $debt->receiver_id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-black text-white px-5 py-2 rounded-full text-[9px] font-bold uppercase tracking-widest hover:scale-105 transition-all italic">
                                                Régler
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-10 opacity-30 font-bold italic">Tout est à jour ! ✨</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-10 italic">Membres</h3>
                    <div class="space-y-6 mb-12">
                        @foreach($members as $m)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center space-x-4">
                                    <div class="w-11 h-11 rounded-2xl bg-black text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                        {{ strtoupper(substr($m->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-sm text-[#1D1D1F] italic">{{ $m->user->name }}</span>
                                </div>
                                @if($m->role === 'owner')
                                    <span class="text-[9px] font-bold uppercase bg-yellow-50 text-yellow-600 px-2 py-1 rounded-lg italic">Owner</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @if($membership->role === 'owner')
                        <div class="pt-8 border-t border-gray-50">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 italic">Inviter</h4>
                            <form action="{{ route('invitations.store', $colocation->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="email" name="email" required placeholder="Email..." class="w-full border-none bg-[#FAFAFA] rounded-2xl p-4 text-xs font-bold italic">
                                <button type="submit" class="w-full bg-black text-white font-bold py-4 rounded-2xl text-[10px] uppercase tracking-widest hover:bg-gray-800 transition-all shadow-lg italic">Envoyer</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="expenseModal" class="fixed inset-0 z-50 hidden bg-black/5 backdrop-blur-md">
        <div class="flex items-center justify-center min-h-screen p-6 text-[#1D1D1F]">
            <div class="bg-white rounded-[3rem] p-12 max-w-lg w-full shadow-2xl border border-gray-100">
                <h3 class="text-3xl font-bold tracking-tighter mb-10 uppercase italic">Nouvelle dépense</h3>
                <form action="{{ route('expenses.store', $colocation->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Désignation</label>
                        <input type="text" name="title" required class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Prix (DH)</label>
                            <input type="number" step="0.01" name="amount" required class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Catégorie</label>
                            <select name="category_id" required class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Date</label>
                        <input type="date" name="spent_at" value="{{ date('Y-m-d') }}" required class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                    </div>
                    <div class="pt-6 space-y-4">
                        <button type="submit" class="w-full bg-black text-white font-bold py-6 rounded-full text-lg shadow-lg uppercase italic tracking-widest">Enregistrer</button>
                        <button type="button" onclick="document.getElementById('expenseModal').classList.add('hidden')" class="w-full text-gray-400 font-bold text-xs uppercase italic tracking-widest">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>