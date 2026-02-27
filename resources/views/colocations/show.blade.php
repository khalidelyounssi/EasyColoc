<x-app-layout>
    <div class="min-h-screen bg-[#FAFAFA] font-sans antialiased text-[#1D1D1F]">
        <div class="py-12 px-6 md:px-12 max-w-7xl mx-auto space-y-10">

            <header class="bg-white rounded-[3rem] p-12 border border-[#F5F5F7] shadow-sm flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
                <div class="flex-1">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-4 block italic underline decoration-indigo-500 decoration-2 underline-offset-8">Espace de vie actif</span>
                    <h1 class="text-6xl font-black text-[#1D1D1F] tracking-tighter italic uppercase leading-tight">{{ $colocation->name }}</h1>
                    <p class="text-gray-400 font-medium mt-6 max-w-xl italic leading-relaxed mx-auto md:mx-0">{{ $colocation->description }}</p>
                </div>
                @if($isActive)
                    <button onclick="document.getElementById('expenseModal').classList.remove('hidden')" class="bg-black text-white px-12 py-6 rounded-full font-bold text-sm shadow-2xl hover:scale-105 active:scale-95 transition-all shrink-0 uppercase tracking-widest italic">
                        + Ajouter une dépense
                    </button>
                @endif
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <div class="lg:col-span-8 space-y-10">
                    
                    <div class="bg-white rounded-[3rem] p-10 border border-[#F5F5F7] shadow-sm">
                        <div class="flex justify-between items-center mb-10 px-4">
                            <h3 class="text-xl font-black italic uppercase tracking-tighter">Flux financier</h3>
                            <form action="{{ route('colocation.show', $colocation->id) }}" method="GET">
                                <select name="month" onchange="this.form.submit()" class="bg-[#FAFAFA] border-none rounded-2xl text-[10px] font-bold uppercase tracking-widest px-6 py-3 italic shadow-sm focus:ring-2 focus:ring-black">
                                    <option value="">Tous les mois</option>
                                    @foreach($availableMonths as $month)
                                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($month)->format('F Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse($expenses as $expense)
                                <div class="flex items-center justify-between py-8 hover:bg-[#FAFAFA] rounded-[2rem] px-4 transition-all">
                                    <div class="flex items-center space-x-6">
                                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-gray-50 italic">🛒</div>
                                        <div>
                                            <p class="font-black text-gray-900 text-xl tracking-tight italic uppercase leading-none">{{ $expense->title }}</p>
                                            <p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest mt-2 italic">
                                                {{ $expense->user->name ?? 'Membre' }} <span class="mx-2">/</span> {{ \Carbon\Carbon::parse($expense->spent_at)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-3xl font-black text-[#1D1D1F] tracking-tighter italic">{{ number_format($expense->amount, 0) }}</span>
                                        <span class="text-[10px] text-gray-300 font-bold uppercase ml-1 italic">DH</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center py-20 text-gray-200 font-bold italic uppercase tracking-widest text-[10px]">Aucun mouvement</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-[3rem] p-10 border border-[#F5F5F7] shadow-sm">
                        <h3 class="text-xl font-black italic uppercase tracking-tighter mb-10 px-4">Balance des comptes</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @forelse($summary as $debt)
                                <div class="bg-[#FAFAFA] p-8 rounded-[2.5rem] flex flex-col justify-between border border-transparent hover:border-gray-100 transition-all">
                                    <div class="flex justify-between items-center mb-8 italic">
                                        <div class="text-center flex-1 uppercase">
                                            <span class="text-[8px] font-bold text-gray-300 block mb-1">Doit payer</span>
                                            <span class="font-black text-xs leading-none">{{ $debt->sender->name }}</span>
                                        </div>
                                        <div class="text-indigo-500 font-black animate-pulse px-3">➔</div>
                                        <div class="text-center flex-1 uppercase">
                                            <span class="text-[8px] font-bold text-gray-300 block mb-1">À</span>
                                            <span class="font-black text-xs leading-none">{{ $debt->receiver->name }}</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-end pt-6 border-t border-white">
                                        <span class="text-3xl font-black tracking-tighter italic">{{ number_format($debt->total, 0) }} <span class="text-[10px] text-gray-300 font-bold uppercase">DH</span></span>
                                        @if($isActive && auth()->id() === $debt->sender_id)
                                            <form action="{{ route('settlements.pay_all', [$colocation->id, $debt->receiver_id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-black text-white px-8 py-3 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-md hover:scale-105 transition-all italic">Régler</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-12 bg-green-50/30 rounded-[2rem] border border-green-50 italic text-green-600 font-bold text-[10px] uppercase tracking-widest">Tout est en ordre ✨</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-8">
                    
                    <div class="bg-white rounded-[3rem] p-10 border border-[#F5F5F7] shadow-sm">
                        <h3 class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.3em] mb-12 italic text-center">Membres du Node</h3>
                        
                        <div class="space-y-8 mb-12 px-2">
                            @foreach($members as $m)
                                <div class="flex items-center justify-between group">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 rounded-xl bg-black text-white flex items-center justify-center text-xs font-black italic shadow-md">{{ strtoupper(substr($m->user->name, 0, 1)) }}</div>
                                        <div class="flex flex-col italic uppercase">
                                            <span class="font-black text-sm text-[#1D1D1F] leading-none">{{ $m->user->name }}</span>
                                            @if($m->role === 'owner') <span class="text-[8px] font-bold text-indigo-500 mt-1 tracking-widest">System Owner</span> @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @if($membership->role === 'owner' && $m->user_id !== auth()->id() && $isActive)
                                            <form action="{{ route('members.transfer', [$colocation->id, $m->user_id]) }}" method="POST" onsubmit="return confirm('Nommer ce membre comme Owner ?')">
                                                @csrf <button type="submit" title="👑" class="text-indigo-400 hover:scale-125 transition-all text-xs">👑</button>
                                            </form>
                                            <form action="{{ route('members.kick', [$colocation->id, $m->user_id]) }}" method="POST" onsubmit="return confirm('Exclure ce membre ?')">
                                                @csrf <button type="submit" class="text-red-300 hover:text-red-500 transition-all text-lg font-bold ml-2">✖</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($isActive && $membership->role === 'owner')
                            <div class="pt-8 border-t border-[#FAFAFA] space-y-10">
                                <div>
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 italic px-2">Node Expansion</h4>
                                    <form action="{{ route('invitations.store', $colocation->id) }}" method="POST" class="flex flex-col space-y-2">
                                        @csrf
                                        <input type="email" name="email" required placeholder="Email du membre..." class="w-full border-none bg-[#FAFAFA] rounded-xl p-4 text-[10px] font-bold italic shadow-inner">
                                        <button type="submit" class="bg-black text-white py-4 rounded-xl text-[10px] font-bold italic shadow-lg hover:scale-[1.02] transition-all uppercase tracking-widest">Inviter ➔</button>
                                    </form>
                                </div>

                                <div>
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 italic px-2">Configuration Catégories</h4>
                                    <form action="{{ route('categories.store', $colocation->id) }}" method="POST" class="flex space-x-2">
                                        @csrf
                                        <input type="text" name="name" required placeholder="ex: Loyer, WiFi..." class="flex-1 border-none bg-[#FAFAFA] rounded-xl p-4 text-[10px] font-bold italic shadow-inner">
                                        <button type="submit" class="bg-indigo-500 text-white px-5 py-4 rounded-xl text-[10px] font-bold italic shadow-lg hover:scale-105 transition-all uppercase">ADD</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        
                        <div class="pt-10 px-2">
                            <form action="{{ route('members.leave', $colocation->id) }}" method="POST" onsubmit="return confirm('Attention : Votre réputation sera impactée par vos dettes.')">
                                @csrf
                                <button type="submit" class="w-full text-red-500 border border-red-50 font-bold py-5 rounded-2xl text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all italic shadow-sm">Quitter le Node</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="expenseModal" class="fixed inset-0 z-50 hidden bg-black/5 backdrop-blur-md">
        <div class="flex items-center justify-center min-h-screen p-6">
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
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Qui a payé ?</label>
                        <select name="paid_by" required class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                            @foreach($members as $m)
                                <option value="{{ $m->user_id }}" {{ auth()->id() == $m->user_id ? 'selected' : '' }}>
                                    {{ $m->user->name }} ({{ ucfirst($m->role) }})
                                </option>
                            @endforeach
                        </select>
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