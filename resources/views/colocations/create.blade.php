<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full px-6">
            
            <div class="text-center mb-8">
                <div class="bg-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-gray-900">Nouvelle Aventure !</h2>
                <p class="text-gray-500 mt-2">Créez votre colocation et commencez à gérer vos dépenses ensemble.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                <form action="{{ route('colocation.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nom de l'espace</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </span>
                            <input type="text" name="name" id="name" required placeholder="Ex: Appat 24, Villa El Amal..." 
                                class="pl-10 block w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition py-3">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-8">
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Petit mot ou règles (Optionnel)</label>
                        <textarea name="description" id="description" rows="3" placeholder="Une petite description pour vos futurs membres..."
                            class="block w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition py-3"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-black py-4 rounded-2xl hover:bg-indigo-700 transition duration-300 shadow-lg shadow-indigo-100 flex items-center justify-center">
                        Lancer la colocation 🚀
                    </button>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-400 hover:text-gray-600 transition">
                            Annuler et retourner
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>