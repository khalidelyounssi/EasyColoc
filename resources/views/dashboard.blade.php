@if(auth()->user()->is_admin)
    <div class="admin-panel">
        <a href="/admin/stats">Statistiques</a>
        <a href="/admin/users">Gérer les Utilisateurs</a>
    </div>
@endif

@foreach($pendingInvitations as $invitation)
    <div class="alert alert-info">
        Tu as une invitation pour rejoindre : {{ $invitation->colocation->name }}
        <button>Accepter</button>
        <button>Refuser</button>
    </div>
@endforeach

@if(!$activeColocation)
    <div class="mt-4">
        <a href="{{ route('colocation.create') }}" class="btn btn-primary">
            Créer une Colocation
        </a>
    </div>
@else
    <h2>Ta Colocation : {{ $activeColocation->colocation->name }}</h2>
@endif

@if($historyColocations->count() > 0)
    <h3>Historique de tes colocations</h3>
    @foreach($historyColocations as $history)
        <p>{{ $history->colocation->name }} (Terminée)</p>
    @endforeach
@endif