<x-guest-layout>
    <div class="min-h-screen bg-[#FAFAFA] flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-[3rem] p-12 shadow-2xl border border-[#F5F5F7] text-center">
            
            <div class="w-16 h-16 bg-black rounded-2xl flex items-center justify-center mx-auto mb-10 shadow-lg transition-transform hover:scale-110">
                <span class="text-white font-bold italic text-3xl">E</span>
            </div>

            <h2 class="text-4xl font-black tracking-tighter mb-2 italic uppercase">Connexion</h2>
            <p class="text-gray-400 font-bold text-[10px] uppercase tracking-[0.2em] mb-12 italic">Accédez à votre espace</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-6 text-left">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-3 italic">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="w-full border-none bg-[#FAFAFA] rounded-[1.5rem] p-6 font-bold italic focus:ring-2 focus:ring-black transition-all placeholder:text-gray-300 shadow-sm" placeholder="exemple@mail.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 ml-3" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-3 italic">Password</label>
                    <input type="password" name="password" required 
                           class="w-full border-none bg-[#FAFAFA] rounded-[1.5rem] p-6 font-bold italic focus:ring-2 focus:ring-black transition-all shadow-sm" placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 ml-3" />
                </div>

                <div class="flex items-center justify-between px-3 mt-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded-lg border-none bg-[#FAFAFA] text-black focus:ring-0 shadow-sm w-5 h-5">
                        <span class="ms-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Rester connecté</span>
                    </label>
                </div>

                <div class="pt-10 space-y-6">
                    <button type="submit" class="w-full bg-black text-white font-bold py-6 rounded-full text-sm shadow-xl hover:bg-zinc-800 active:scale-95 transition-all uppercase tracking-[0.2em] italic">
                        Se connecter
                    </button>
                    
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('register') }}" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic hover:text-black transition-colors">
                            Créer un compte
                        </a>
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-bold text-gray-300 uppercase tracking-widest italic hover:text-red-400 transition-colors" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>