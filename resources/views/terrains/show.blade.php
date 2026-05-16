<x-app-layout>

<div class="container">
    <h2>Détails du Terrain</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $terrain->name }}</h4>
            <p><strong>Prix :</strong> {{ $terrain->price_per_hour }} DH / heure</p>
            <p>
                <strong>Status :</strong>
                @if($terrain->status)
                    <span class="badge bg-success">Actif</span>
                @else
                    <span class="badge bg-danger">Inactif</span>
                @endif
            </p>
        </div>
    </div>

    <a href="{{ route('terrains.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
</x-app-layout>
