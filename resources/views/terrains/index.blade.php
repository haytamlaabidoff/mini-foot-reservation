<x-app-layout>

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">🏟️ Gestion des Terrains</h2>
            <p class="text-gray-500 text-sm">Liste des terrains disponibles</p>
        </div>

        <a href="{{ route('terrains.create') }}"
           class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded-lg shadow">
            + Ajouter Terrain
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">

                {{-- HEADER --}}
                <thead class="bg-gray-900 text-white uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Nom</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">terrain_condition</th>
                        <th class="px-4 py-3">Prix / Heure</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-gray-200">

                    @forelse($terrains as $terrain)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-4 py-3 font-semibold text-gray-700">
                                #{{ $terrain->id }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-800">
                                    {{ $terrain->name }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    Terrain sportif
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                                    ⚽ {{ $terrain->sportFormat->name }}
                                </span>
                            </td>
<td class="px-4 py-3">
    <form action="{{ route('terrains.toggleCondition', $terrain->id) }}" method="POST">
        @csrf
        @method('PATCH')

        @if($terrain->terrain_condition === 'praticable')
            <button type="submit"
                class="px-3 py-1 text-xs font-semibold bg-green-600 text-white rounded-full hover:bg-green-700 transition">
                ✔ Praticable
            </button>
        @else
            <button type="submit"
                class="px-3 py-1 text-xs font-semibold bg-red-600 text-white rounded-full hover:bg-red-700 transition">
                ⚠ Impraticable
            </button>
        @endif
    </form>
</td>
                            <td class="px-4 py-3 font-bold text-green-600">
                                {{ $terrain->price_per_hour }} DH
                            </td>

                            <td class="px-4 py-3">
                                @if($terrain->status)
                                    <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                        Actif
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                                        Inactif
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right space-x-2">

                                <a href="{{ route('terrains.show', $terrain->id) }}"
                                   class="px-3 py-1 text-xs bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200">
                                    Voir
                                </a>

                                <a href="{{ route('terrains.edit', $terrain->id) }}"
                                   class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">
                                    Edit
                                </a>

                                <form action="{{ route('terrains.destroy', $terrain->id) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Supprimer ce terrain ?')"
                                            class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded hover:bg-red-200">
                                        Delete
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                🚫 Aucun terrain trouvé
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

</x-app-layout>