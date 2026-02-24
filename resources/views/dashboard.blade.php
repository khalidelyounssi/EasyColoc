<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(auth()->user()->is_admin)
                <div class="mb-8 bg-indigo-900 rounded-xl p-6 text-white shadow-lg flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold">Panel Administrateur</h2>
                        <p class="text-indigo-200">Gérez les utilisateurs et consultez les statistiques globales.</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-white text-indigo-900 px-4 py-2 rounded-lg font-semibold hover:bg-indigo-100 transition">Statistiques</a>
                        <a href="#" class="bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-800 transition">Utilisateurs</a>
                    </div>
                </div>
            @endif

            @foreach($pendingInvitations as $invitation)
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 shadow-sm flex justify-between items-center rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-yellow-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                        <p class="text-yellow-700">Vous avez été invité à rejoindre <strong>{{ $invitation->colocation->name }}</strong></p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Accepter</button>
                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Refuser</button>
                    </div>
                </div>
            @endforeach

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    @if(!$activeColocation)
                        <div class="bg-white rounded-2xl shadow-sm p-10 text-center border-2 border-dashed border-gray-200">
                            <div class="mb-4 bg-indigo-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Aucune colocation active</h3>
                            <p class="text-gray-500 mb-6">Créez votre propre espace ou attendez une invitation.</p>
                            <a href="{{ route('colocation.create') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-md">
                                Créer une Colocation
                            </a>
                        </div>
                    @else
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition">
                            <div class="bg-indigo-600 p-4 text-white flex justify-between items-center">
                                <span class="font-bold text-lg">{{ $activeColocation->colocation->name }}</span>
                                <span class="bg-indigo-500 px-3 py-1 rounded-full text-xs uppercase tracking-wider">Actif</span>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-600 mb-6">{{ Str::limit($activeColocation->colocation->description, 100) }}</p>
                                <a href="{{ route('colocation.show', $activeColocation->colocation->id) }}" class="text-indigo-600 font-bold hover:underline flex items-center">
                                    Gérer ma colocation
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            Ma Réputation
                        </h4>
                        <div class="text-3xl font-black text-indigo-600">{{ auth()->user()->reputation_score }} <span class="text-sm text-gray-400 font-normal">pts</span></div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <h4 class="font-bold text-gray-800 mb-4">Historique</h4>
                        @forelse($historyColocations as $history)
                            <div class="py-3 border-b border-gray-50 last:border-0 flex justify-between items-center text-sm">
                                <span class="text-gray-600 font-medium">{{ $history->colocation->name }}</span>
                                <span class="text-gray-400 italic">Terminée</span>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm italic">Aucun historique.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>