<x-app-layout>
    <div class="flex min-h-screen bg-[#FAFAFA] font-sans antialiased text-[#1D1D1F]">

        <aside
            class="fixed left-0 top-0 h-screen w-72 bg-white border-r border-[#F5F5F7] p-8 flex flex-col justify-between shadow-sm z-50">
            <div class="space-y-12">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group px-2">
                    <div
                        class="w-12 h-12 bg-black rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-all">
                        <span class="text-white font-bold italic text-2xl">E</span>
                    </div>
                    <span class="text-2xl font-black tracking-tighter text-[#1D1D1F]">EasyColoc</span>
                </a>

                <nav class="space-y-2">
                    <span
                        class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em] px-4 mb-4 block italic">Menu
                        Principal</span>

                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-4 px-4 py-4 rounded-3xl transition-all {{ request()->routeIs('dashboard') ? 'bg-black text-white shadow-xl italic' : 'text-gray-400 hover:bg-gray-50 hover:text-black' }}">
                        <span class="text-xl">🏠</span>
                        <span class="text-sm font-bold uppercase tracking-widest">Dashboard</span>
                    </a>

                    @if(Auth::user()->is_admin)
                        <span
                            class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em] px-4 mt-8 mb-4 block italic">Administration</span>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center space-x-4 px-4 py-4 rounded-3xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-xl italic' : 'text-gray-400 hover:bg-indigo-50 hover:text-indigo-600' }}">
                            <span class="text-xl">🛡️</span>
                            <span class="text-sm font-bold uppercase tracking-widest">Gestion Globale</span>
                        </a>
                    @endif

                    <span
                        class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em] px-4 mt-8 mb-4 block italic">Utilisateur</span>
                    <a href="#"
                        class="flex items-center space-x-4 px-4 py-4 rounded-3xl text-gray-400 hover:bg-gray-50 hover:text-black transition-all">
                        <span class="text-xl">📊</span>
                        <span class="text-sm font-bold uppercase tracking-widest">Dépenses</span>
                    </a>
                </nav>
            </div>

            <div class="pt-8 border-t border-gray-50 space-y-6">
                <div class="px-4 text-right">
                    <span
                        class="text-[10px] font-bold text-gray-300 uppercase tracking-widest block mb-1">Session</span>
                    <p class="text-sm font-black text-black italic truncate">{{ Auth::user()->name }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-50 text-red-600 p-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest border border-red-100 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 ml-72">
            <div class="py-12 px-12 max-w-7xl mx-auto space-y-8">

                <header
                    class="bg-white rounded-[2rem] p-10 border border-[#F5F5F7] shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <span
                            class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-2 block italic">Espace
                            de vie</span>
                        <h1 class="text-5xl font-bold text-[#1D1D1F] tracking-tighter leading-tight italic">
                            {{ $colocation->name }}
                        </h1>
                        <p class="text-gray-500 font-medium mt-4 max-w-xl italic">{{ $colocation->description }}</p>
                    </div>

                    @if($isActive)
                        <button onclick="document.getElementById('expenseModal').classList.remove('hidden')"
                            class="bg-black text-white px-10 py-5 rounded-full font-bold text-sm shadow-xl hover:scale-105 transition-all shrink-0 uppercase tracking-widest italic">
                            + Ajouter une dépense
                        </button>
                    @else
                        <div class="bg-amber-50 px-6 py-4 rounded-2xl border border-amber-100 flex items-center italic">
                            <span class="text-amber-600 font-bold text-[10px] uppercase tracking-widest italic">⚠️ Mode
                                lecture seule</span>
                        </div>
                    @endif
                </header>


                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-8 space-y-8">

                        <div class="bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-[#1D1D1F] italic uppercase tracking-tighter mb-10">
                                    Historique des transactions</h3>
                                <form action="{{ route('colocation.show', $colocation->id) }}" method="GET"
                                    class="flex items-center space-x-3">
                                    <select name="month" onchange="this.form.submit()"
                                        class="bg-white border-none rounded-xl text-[10px] font-bold uppercase tracking-widest shadow-sm px-4 py-2 italic">
                                        <option value="">Tous les mois</option>
                                        @foreach($availableMonths as $month)
                                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::parse($month)->format('F Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            <div class="space-y-6">
                                @forelse($colocation->expenses->sortByDesc('spent_at') as $expense)
                                    <div
                                        class="flex items-center justify-between p-6 hover:bg-[#FAFAFA] rounded-3xl transition-colors group border border-transparent hover:border-gray-100">
                                        <div class="flex items-center space-x-6">
                                            <div
                                                class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-gray-50 group-hover:scale-110 transition-transform">
                                                🛒</div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-lg tracking-tight">
                                                    {{ $expense->title }}
                                                </p>
                                                <p
                                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1 italic">
                                                    {{ $expense->user->name ?? 'Membre' }} •
                                                    {{ \Carbon\Carbon::parse($expense->spent_at)->format('d M') }}
                                                </p>
                                            </div>
                                        </div>
                                        <span
                                            class="text-2xl font-bold text-[#1D1D1F] tracking-tighter italic">{{ number_format($expense->amount, 0) }}
                                            <span class="text-xs text-gray-400 font-bold uppercase">DH</span></span>
                                    </div>
                                @empty
                                    <div class="text-center py-20 opacity-30 font-bold italic">Aucune dépense.</div>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm">
                            <h3 class="text-xl font-bold text-[#1D1D1F] italic uppercase tracking-tighter mb-10">
                                Récapitulatif des comptes</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @forelse($summary as $debt)
                                    <div
                                        class="bg-[#FAFAFA] p-6 rounded-3xl flex flex-col justify-between border border-transparent hover:border-gray-100 transition-all group">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 italic">Doit
                                                    payer</span>
                                                <span class="font-bold text-black italic">{{ $debt->sender->name }}</span>
                                            </div>
                                            <div
                                                class="w-8 h-8 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                                ➔</div>
                                            <div class="flex flex-col items-end">
                                                <span
                                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 italic">À</span>
                                                <span class="font-bold text-black italic">{{ $debt->receiver->name }}</span>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-end pt-4 border-t border-white">
                                            <span
                                                class="text-2xl font-black tracking-tighter italic">{{ number_format($debt->total, 0) }}
                                                <span class="text-xs text-gray-400 uppercase italic">DH</span></span>
                                            @if($isActive && auth()->id() === $debt->sender_id)
                                                <form
                                                    action="{{ route('settlements.pay_all', [$colocation->id, $debt->receiver_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-black text-white px-5 py-2 rounded-full text-[9px] font-bold uppercase tracking-widest hover:scale-105 transition-all italic">Régler</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-2 text-center py-10 opacity-30 font-bold italic">Tout est à jour !
                                        ✨</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm">
                            <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-10 italic">
                                Membres</h3>
                            <div class="space-y-6 mb-12">
                                @foreach($members as $m)
                                    <div class="flex items-center justify-between group">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-black text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                                {{ strtoupper(substr($m->user->name, 0, 1)) }}
                                            </div>
                                            <span
                                                class="font-bold text-sm text-[#1D1D1F] italic">{{ $m->user->name }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($m->role === 'owner')
                                                <span
                                                    class="text-[9px] font-bold uppercase bg-yellow-50 text-yellow-600 px-2 py-1 rounded-lg italic">Owner</span>
                                            @elseif($membership->role === 'owner' && $isActive)
                                                <form action="{{ route('members.kick', [$colocation->id, $m->user_id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment exclure ce membre ?')">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-red-400 hover:text-red-600 transition-colors p-1 text-lg">✖</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-8 border-t border-gray-50 space-y-4">
                                @if($isActive)
                                    @if($membership->role === 'owner')
                                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 italic">
                                            Inviter</h4>
                                        <form action="{{ route('invitations.store', $colocation->id) }}" method="POST"
                                            class="space-y-4">
                                            @csrf
                                            <input type="email" name="email" required placeholder="Email..."
                                                class="w-full border-none bg-[#FAFAFA] rounded-2xl p-4 text-xs font-bold italic">
                                            <button type="submit"
                                                class="w-full bg-black text-white font-bold py-4 rounded-2xl text-[10px] uppercase tracking-widest hover:bg-gray-800 transition-all shadow-lg italic">Envoyer</button>
                                        </form>
                                    @else
                                        <form action="{{ route('members.leave', $colocation->id) }}" method="POST"
                                            onsubmit="return confirm('Voulez-vous vraiment quitter ?')">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-red-500 border border-red-100 font-bold py-4 rounded-2xl text-[10px] uppercase tracking-widest hover:bg-red-50 transition-all italic">Quitter</button>
                                        </form>
                                    @endif
                                @endif
                            </div>

                            @if($membership->role === 'owner' && $isActive)
                                <div class="pt-8 border-t border-gray-50 mt-8">
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 italic">
                                        Nouvelle Catégorie</h4>
                                    <form action="{{ route('categories.store', $colocation->id) }}" method="POST"
                                        class="space-y-4">
                                        @csrf
                                        <input type="text" name="name" required placeholder="Nom (ex: Internet)..."
                                            class="w-full border-none bg-[#FAFAFA] rounded-2xl p-4 text-xs font-bold italic">
                                        <button type="submit"
                                            class="w-full bg-indigo-500 text-white font-bold py-4 rounded-2xl text-[10px] uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg italic">Ajouter</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="expenseModal" class="fixed inset-0 z-50 hidden bg-black/5 backdrop-blur-md">
        <div class="flex items-center justify-center min-h-screen p-6 text-[#1D1D1F]">
            <div class="bg-white rounded-[3rem] p-12 max-w-lg w-full shadow-2xl border border-gray-100">
                <h3 class="text-3xl font-bold tracking-tighter mb-10 uppercase italic">Nouvelle dépense</h3>
                <form action="{{ route('expenses.store', $colocation->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Désignation</label>
                        <input type="text" name="title" required
                            class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Prix
                                (DH)</label>
                            <input type="number" step="0.01" name="amount" required
                                class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Catégorie</label>
                            <select name="category_id" required
                                class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Qui
                                a payé ?</label>
                            <select name="paid_by" required
                                class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                                @foreach($members as $m)
                                    <option value="{{ $m->user_id }}" {{ auth()->id() == $m->user_id ? 'selected' : '' }}>
                                        {{ $m->user->name }} ({{ ucfirst($m->role) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2 italic">Date</label>
                        <input type="date" name="spent_at" value="{{ date('Y-m-d') }}" required
                            class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold italic">
                    </div>
                    <div class="pt-6 space-y-4">
                        <button type="submit"
                            class="w-full bg-black text-white font-bold py-6 rounded-full text-lg shadow-lg uppercase italic tracking-widest">Enregistrer</button>
                        <button type="button" onclick="document.getElementById('expenseModal').classList.add('hidden')"
                            class="w-full text-gray-400 font-bold text-xs uppercase italic tracking-widest">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>