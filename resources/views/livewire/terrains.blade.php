<div class="p-6 bg-white rounded shadow">

    <h2 class="text-xl font-bold mb-4">Gestion des Terrains</h2>

    @if (session()->has('message'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Form Ajouter Terrain -->
    <div class="mb-6">
        <input type="text" wire:model="name" placeholder="Nom du terrain" class="border p-2 rounded mr-2">
        <input type="number" wire:model="price_per_hour" placeholder="Prix par heure" class="border p-2 rounded mr-2">
        <button wire:click="addTerrain" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
    </div>

    <!-- Liste des terrains -->
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Nom</th>
                <th class="p-2 border">Prix/heure</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($terrains as $terrain) <!-- public $terrains موجود -->
            <tr>
                <td class="p-2 border">{{ $terrain->name }}</td>
                <td class="p-2 border">{{ $terrain->price_per_hour }} DH</td>
                <td class="p-2 border">
                    <button wire:click="deleteTerrain({{ $terrain->id }})" class="bg-red-500 text-white px-3 py-1 rounded">Supprimer</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>