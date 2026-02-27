<x-guest-layout>
    <div class="min-h-screen bg-[#FAFAFA] flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-[3rem] p-12 shadow-2xl border border-[#F5F5F7] text-center">
            
            <div class="w-16 h-16 bg-black rounded-2xl flex items-center justify-center mx-auto mb-10 shadow-lg transition-transform hover:scale-110">
                <span class="text-white font-bold italic text-3xl">E</span>
            </div>

            <h2 class="text-4xl font-black tracking-tighter mb-2 italic uppercase">Inscription</h2>
            <p class="text-gray-400 font-bold text-[10px] uppercase tracking-[0.2em] mb-12 italic">Rejoignez l'aventure</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5 text-left">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-3 italic">Nom complet</label>
                    <input type="text" name="name" :value="old('name')" required autofocus 
                           class="w-full border-none bg-[#FAFAFA] rounded-[1.5rem] p-6 font-bold italic focus:ring-2 focus:ring-black transition-all shadow-sm">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 ml-3" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-3 italic">Email Address</label>
                    <input type="email" name="email" value="{{ request('email') ?? old('email') }}" required 
                           class="w-full border-none bg-[#FAFAFA] rounded-[1.5rem] p-6 font-bold italic focus:ring-2 focus:ring-black transition-all shadow-sm">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 ml-3" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-3 italic">Mot de passe</label>
                        <input type="password" name="password" required 
                               class="w-full border-none bg-[#FAFAFA] rounded-[1.5rem] p-6 font-bold italic focus:ring-2 focus:ring-black transition-all shadow-sm text-xs">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-3 italic">Confirmer</label>
                        <input type="password" name="password_confirmation" required 
                               class="w-full border-none bg-[#FAFAFA] rounded-[1.5rem] p-6 font-bold italic focus:ring-2 focus:ring-black transition-all shadow-sm text-xs">
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 ml-3" />

                <div class="pt-10 space-y-6">
                    <button type="submit" class="w-full bg-black text-white font-bold py-6 rounded-full text-sm shadow-xl hover:bg-zinc-800 active:scale-95 transition-all uppercase tracking-[0.2em] italic">
                        Créer mon compte
                    </button>
                    
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic text-center">
                        Déjà inscrit ? <a href="{{ route('login') }}" class="text-black hover:underline ml-1">Se connecter</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>