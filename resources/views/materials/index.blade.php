<x-app-layout>

<div class="max-w-7xl mx-auto p-6">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-3xl font-bold">
            🧰 Liste des Matériels
        </h2>

        <a href="{{ route('materials.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl">

            + Ajouter Matériel
        </a>

    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-2xl overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">Terrain</th>
                    <th class="p-4 text-left">Nom</th>
                    <th class="p-4 text-center">Quantité</th>
                    <th class="p-4 text-center">État</th>
                    <th class="p-4 text-center">Actions</th>

                </tr>

            </thead>

            <tbody>

                @forelse($materials as $material)

                <tr class="border-t">

                    <td class="p-4">
                        {{ $material->terrain->name ?? '-' }}
                    </td>

                    <td class="p-4 font-semibold">
                        {{ $material->name }}
                    </td>

                    <td class="p-4 text-center">
                        {{ $material->quantity }}
                    </td>

                    <td class="p-4 text-center">

                        @if($material->condition == 'new')
                            🟢 Neuf
                        @elseif($material->condition == 'good')
                            🔵 Bon
                        @elseif($material->condition == 'damaged')
                            🟠 Endommagé
                        @else
                            🔴 Cassé
                        @endif

                    </td>

                    <td class="p-4 text-center flex justify-center gap-2">

                        <a href="{{ route('materials.edit', $material->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

                            Modifier
                        </a>

                        <form action="{{ route('materials.destroy', $material->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Supprimer ?')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                Supprimer
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5"
                        class="p-6 text-center text-gray-500">

                        Aucun matériel trouvé.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>
