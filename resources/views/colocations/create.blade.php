<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#FAFAFA] p-6 font-sans antialiased">
        
        <div class="max-w-xl w-full bg-white rounded-[3rem] p-12 border border-[#F5F5F7] shadow-sm">
            
            <div class="text-center mb-12">
                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-[0.3em] mb-4 block">Nouvelle étape</span>
                <h2 class="text-5xl font-bold text-[#1D1D1F] tracking-tighter leading-tight">Créer un espace</h2>
                <p class="text-gray-400 font-medium mt-4">Lancez votre colocation et commencez à gérer vos comptes.</p>
            </div>

            <form action="{{ route('colocation.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-2">Nom de la colocation</label>
                    <input type="text" name="name" required placeholder="Ex: Appartement 12" 
                        class="w-full bg-[#FAFAFA] border-none rounded-2xl p-5 font-bold text-[#1D1D1F] focus:ring-2 focus:ring-black transition-all placeholder-gray-300">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-2">Description (Optionnel)</label>
                    <textarea name="description" rows="3" placeholder="Un petit mot pour vos futurs colocataires..." 
                        class="w-full bg-[#FAFAFA] border-none rounded-2xl p-5 font-bold text-[#1D1D1F] focus:ring-2 focus:ring-black transition-all placeholder-gray-300"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-black text-white font-bold py-6 rounded-full text-lg shadow-xl shadow-gray-200 hover:scale-[1.02] active:scale-95 transition-all">
                        Lancer l'aventure 🚀
                    </button>
                    
                    <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-sm font-bold text-gray-400 hover:text-black transition-colors">
                        Annuler et retourner
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>