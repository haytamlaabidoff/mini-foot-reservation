<x-app-layout>

<div class="max-w-3xl mx-auto p-6">

    <div class="bg-white shadow rounded-2xl p-6">

        <h2 class="text-3xl font-bold mb-6">
            ➕ Ajouter Matériel
        </h2>

        <form method="POST"
              action="{{ route('materials.store') }}">

            @csrf

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Terrain
                </label>

                <select name="terrain_id"
                        class="w-full border rounded-xl p-3">

                    @foreach($terrains as $terrain)

                        <option value="{{ $terrain->id }}">
                            {{ $terrain->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Nom du matériel
                </label>

                <input type="text"
                       name="name"
                       class="w-full border rounded-xl p-3"
                       required>

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Quantité
                </label>

                <input type="number"
                       name="quantity"
                       value="1"
                       class="w-full border rounded-xl p-3">

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    État
                </label>

                <select name="condition"
                        class="w-full border rounded-xl p-3">

                    <option value="new">Neuf</option>
                    <option value="good">Bon</option>
                    <option value="damaged">Endommagé</option>
                    <option value="broken">Cassé</option>

                </select>

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-semibold">
                    Description
                </label>

                <textarea name="description"
                          rows="4"
                          class="w-full border rounded-xl p-3"></textarea>

            </div>

            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl">

                Enregistrer
            </button>

        </form>

    </div>

</div>

</x-app-layout>