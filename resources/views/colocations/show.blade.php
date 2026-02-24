<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    🏠 {{ $colocation->name }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">{{ $colocation->description }}</p>
            </div>
            
            @if($membership->role === 'owner')
                <div class="mt-4 md:mt-0 flex space-x-2">
                    <button class="bg-indigo-600 text-white px-5 py-2 rounded-xl shadow-sm hover:bg-indigo-700 transition font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Inviter un membre
                    </button>
                    <button class="bg-white text-gray-700 border border-gray-200 px-5 py-2 rounded-xl shadow-sm hover:bg-gray-50 transition font-semibold">
                        Paramètres
                    </button>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Dépenses Récentes</h3>
                            <a href="#" class="text-indigo-600 font-bold text-sm hover:underline">+ Nouvelle dépense</a>
                        </div>

                        <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-xl">
                            <div class="bg-gray-50 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-gray-400">Aucune dépense enregistrée pour le moment.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Qui doit quoi ?</h3>
                        <div class="bg-green-50 p-4 rounded-xl text-green-700 font-medium text-sm">
                            🎉 Tous les comptes sont à jour !
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Membres ({{ $members->count() }})
                        </h3>
                        <div class="space-y-4">
                            @foreach($members as $m)
                                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3">
                                            {{ strtoupper(substr($m->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-800">{{ $m->user->name }}</div>
                                            <div class="text-xs text-gray-400 capitalize">{{ $m->role }}</div>
                                        </div>
                                    </div>
                                    @if($m->role === 'owner')
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>