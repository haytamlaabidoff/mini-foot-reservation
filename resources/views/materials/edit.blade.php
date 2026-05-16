<x-app-layout>

<div class="max-w-3xl mx-auto p-6">

    <div class="bg-white shadow rounded-2xl p-6">

        <h2 class="text-3xl font-bold mb-6">
            ✏️ Modifier Matériel
        </h2>

        <form method="POST"
              action="{{ route('materials.update', $material->id) }}">

            @csrf
            @method('PUT')

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Terrain
                </label>

                <select name="terrain_id"
                        class="w-full border rounded-xl p-3">

                    @foreach($terrains as $terrain)

                        <option value="{{ $terrain->id }}"
                            {{ $material->terrain_id == $terrain->id ? 'selected' : '' }}>

                            {{ $terrain->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Nom
                </label>

                <input type="text"
                       name="name"
                       value="{{ $material->name }}"
                       class="w-full border rounded-xl p-3">

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Quantité
                </label>

                <input type="number"
                       name="quantity"
                       value="{{ $material->quantity }}"
                       class="w-full border rounded-xl p-3">

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    État
                </label>

                <select name="condition"
                        class="w-full border rounded-xl p-3">

                    <option value="new"
                        {{ $material->condition == 'new' ? 'selected' : '' }}>
                        Neuf
                    </option>

                    <option value="good"
                        {{ $material->condition == 'good' ? 'selected' : '' }}>
                        Bon
                    </option>

                    <option value="damaged"
                        {{ $material->condition == 'damaged' ? 'selected' : '' }}>
                        Endommagé
                    </option>

                    <option value="broken"
                        {{ $material->condition == 'broken' ? 'selected' : '' }}>
                        Cassé
                    </option>

                </select>

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-semibold">
                    Description
                </label>

                <textarea name="description"
                          rows="4"
                          class="w-full border rounded-xl p-3">{{ $material->description }}</textarea>

            </div>

            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl">

                Mettre à jour
            </button>

        </form>

    </div>

</div>

</x-app-layout>