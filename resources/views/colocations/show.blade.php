<x-app-layout>
    <div class="py-12 px-6 max-w-7xl mx-auto space-y-8 bg-[#FAFAFA] min-h-screen font-sans antialiased">
        
        <header class="bg-white rounded-[2rem] p-10 border border-[#F5F5F7] shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-2 block">Space Details</span>
                <h1 class="text-5xl font-bold text-[#1D1D1F] tracking-tighter leading-tight">{{ $colocation->name }}</h1>
                <p class="text-gray-500 font-medium mt-4 max-w-xl">{{ $colocation->description }}</p>
            </div>
            <button onclick="document.getElementById('expenseModal').classList.remove('hidden')" 
                class="bg-black text-white px-10 py-5 rounded-full font-bold text-sm shadow-xl hover:scale-105 transition-all shrink-0">
                + Ajouter une dépense
            </button>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8 bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-xl font-bold text-[#1D1D1F]">Historique des transactions</h3>
                    <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Mise à jour en direct</span>
                </div>
                
                <div class="space-y-6">
                    @forelse($colocation->expenses->sortByDesc('spent_at') as $expense)
                        <div class="flex items-center justify-between p-6 hover:bg-[#FAFAFA] rounded-3xl transition-colors group">
                            <div class="flex items-center space-x-6">
                                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-gray-50 group-hover:scale-110 transition-transform">
                                    🛒
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-lg">{{ $expense->title }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">
                                        {{ $expense->user->name }} • {{ \Carbon\Carbon::parse($expense->spent_at)->format('d M') }}
                                    </p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-[#1D1D1F] tracking-tighter">{{ number_format($expense->amount, 0) }} <span class="text-xs text-gray-400 font-bold">DH</span></span>
                        </div>
                    @empty
                        <div class="text-center py-20 opacity-30 font-bold italic">Aucune dépense enregistrée.</div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-[2.5rem] p-10 border border-[#F5F5F7] shadow-sm">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-10">Membres de la coloc</h3>
                    <div class="space-y-6">
                        @foreach($members as $m)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-11 h-11 rounded-2xl bg-black text-white flex items-center justify-center text-xs font-bold border border-gray-100 shadow-sm">
                                        {{ strtoupper(substr($m->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-sm text-[#1D1D1F]">{{ $m->user->name }}</span>
                                </div>
                                @if($m->role === 'owner')
                                    <span class="text-[9px] font-bold uppercase bg-[#FFD60A]/10 text-[#FFD60A] px-2 py-1 rounded-lg">Owner</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="expenseModal" class="fixed inset-0 z-50 hidden bg-black/5 backdrop-blur-md">
        <div class="flex items-center justify-center min-h-screen p-6">
            <div class="bg-white rounded-[3rem] p-12 max-w-lg w-full shadow-2xl border border-gray-100">
                <h3 class="text-3xl font-bold tracking-tighter mb-10">Nouvelle dépense</h3>
                
                <form action="{{ route('expenses.store', $colocation->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2">Désignation</label>
                            <input type="text" name="title" required placeholder="Ex: Panier BIM" 
                                class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold focus:ring-2 focus:ring-black">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2">Prix (DH)</label>
                                <input type="number" step="0.01" name="amount" required placeholder="0.00" 
                                    class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold text-xl focus:ring-2 focus:ring-black">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2">Catégorie</label>
                                <select name="category_id" required class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold focus:ring-2 focus:ring-black text-sm">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-2">Date</label>
                            <input type="date" name="spent_at" value="{{ date('Y-m-d') }}" required 
                                class="w-full border-none bg-[#FAFAFA] rounded-2xl p-5 font-bold text-gray-500 focus:ring-2 focus:ring-black">
                        </div>
                    </div>

                    <div class="pt-6 space-y-4">
                        <button type="submit" class="w-full bg-black text-white font-bold py-6 rounded-full text-lg shadow-lg hover:bg-gray-800 transition-all active:scale-95">
                            Enregistrer ➔
                        </button>
                        <button type="button" onclick="document.getElementById('expenseModal').classList.add('hidden')" class="w-full text-gray-400 font-bold text-xs uppercase tracking-widest">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>