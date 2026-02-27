<x-app-layout>
    <div class="flex min-h-screen bg-[#FAFAFA] font-sans antialiased text-[#1D1D1F]">
        
        <aside class="fixed left-0 top-0 h-screen w-72 bg-white border-r border-[#F5F5F7] p-8 flex flex-col justify-between shadow-sm z-50">
            <div class="space-y-12">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group px-2">
                    <div class="w-12 h-12 bg-black rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-all">
                        <span class="text-white font-bold italic text-2xl leading-none">E</span>
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
                    <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest block mb-1 leading-none">Session</span>
                    <p class="text-xs font-black text-black italic truncate">{{ Auth::user()->name }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-50 text-red-600 p-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest border border-red-100 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 ml-72 flex items-center justify-center p-12">
            <div class="max-w-xl w-full bg-white rounded-[3rem] p-12 border border-[#F5F5F7] shadow-sm">
                
                <div class="text-center mb-12">
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-[0.3em] mb-4 block italic">Nouvelle étape</span>
                    <h2 class="text-5xl font-bold text-[#1D1D1F] tracking-tighter leading-tight italic">Créer un espace</h2>
                    <p class="text-gray-400 font-medium mt-4 italic">Lancez votre colocation et commencez à gérer vos comptes.</p>
                </div>

                <form action="{{ route('colocation.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-2 italic">Nom de la colocation</label>
                        <input type="text" name="name" required placeholder="Ex: Appartement 12" 
                            class="w-full bg-[#FAFAFA] border-none rounded-2xl p-5 font-bold text-[#1D1D1F] focus:ring-2 focus:ring-black transition-all placeholder-gray-300 italic">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-2 italic">Description (Optionnel)</label>
                        <textarea name="description" rows="3" placeholder="Un petit mot..." 
                            class="w-full bg-[#FAFAFA] border-none rounded-2xl p-5 font-bold text-[#1D1D1F] focus:ring-2 focus:ring-black transition-all placeholder-gray-300 italic"></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-black text-white font-bold py-6 rounded-full text-lg shadow-xl hover:scale-[1.02] active:scale-95 transition-all uppercase tracking-widest italic">
                            Lancer l'aventure 🚀
                        </button>
                        
                        <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-[10px] font-bold text-gray-400 hover:text-black transition-colors uppercase tracking-widest italic">
                            Annuler et retourner
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>