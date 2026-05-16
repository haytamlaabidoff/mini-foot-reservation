<x-app-layout>

<div class="container">
    <h2>Modifier Terrain</h2>

    <form action="{{ route('terrains.update', $terrain->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" value="{{ $terrain->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Prix / Heure</label>
            <input type="number" step="0.01" name="price_per_hour" value="{{ $terrain->price_per_hour }}" class="form-control" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="status" class="form-check-input"
                {{ $terrain->status ? 'checked' : '' }}>
            <label class="form-check-label">Actif</label>
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('terrains.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
</x-app-layout>
