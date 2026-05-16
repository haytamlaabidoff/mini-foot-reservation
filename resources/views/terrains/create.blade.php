<x-app-layout>
<div class="max-w-3xl mx-auto py-10 px-6">

    <!-- Title -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Ajouter un terrain
    </h2>

    <!-- Errors -->
    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-100 border border-red-300 p-4">
            <strong class="text-red-700">⚠️ Il y a des erreurs :</strong>
            <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white shadow-lg rounded-2xl p-6">

        <form action="{{ route('terrains.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nom -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nom
                </label>
                <input type="text" name="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-green-500 shadow-sm"
                    required>
            </div>

            <!-- Prix -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Prix / Heure
                </label>
                <input type="number" step="0.01" name="price_per_hour"
                    value="{{ old('price_per_hour') }}"
                    class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-green-500 shadow-sm"
                    required>
            </div>

            <!-- SPORT -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Sport
                </label>

                <select id="sport_id" name="sport_id"
                    class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-green-500 shadow-sm"
                    required>

                    <option value="">-- Choisir un sport --</option>

                    @foreach($sports as $sport)
                        <option value="{{ $sport->id }}">
                            {{ $sport->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- FORMAT (DYNAMIC) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Format du terrain
                </label>

                <select id="sport_format_id" name="sport_format_id"
                    class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-green-500 shadow-sm"
                    required>

                    <option value="">-- Choisir un format --</option>

                </select>
            </div>

            <!-- Nombre de jours -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre de jours
                </label>

                <input type="number" name="number_of_days"
                    value="{{ old('number_of_days', 1) }}"
                    min="1"
                    class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-green-500 shadow-sm"
                    required>
            </div>

            <!-- Status -->
            <div class="flex items-center gap-3">
                <input type="checkbox" name="status"
                    class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500"
                    {{ old('status', true) ? 'checked' : '' }}>

                <label class="text-sm text-gray-700">
                    Actif
                </label>
            </div>

            <!-- Condition -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    État du terrain
                </label>

                <select name="terrain_condition"
                    class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-green-500 shadow-sm">

                    <option value="praticable">Praticable</option>
                    <option value="impraticable">Impraticable</option>

                </select>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('terrains.index') }}"
                    class="px-4 py-2 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Retour
                </a>

                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-green-600 text-white font-semibold hover:bg-green-700">
                    Enregistrer
                </button>

            </div>

        </form>
    </div>
</div>

<!-- JS AJAX -->
<script>
document.getElementById('sport_id').addEventListener('change', function () {

    let sportId = this.value;
    let formatSelect = document.getElementById('sport_format_id');

    console.log("Sport ID:", sportId); // 🔥 debug

    formatSelect.innerHTML = '<option>Chargement...</option>';

    if (!sportId) {
        formatSelect.innerHTML = '<option value="">-- Choisir un format --</option>';
        return;
    }

    fetch(`/sport-formats/${sportId}`)
        .then(response => {
            console.log("Response status:", response.status); // 🔥 debug
            return response.json();
        })
        .then(data => {

            console.log("Formats:", data); // 🔥 debug

            formatSelect.innerHTML = '<option value="">-- Choisir un format --</option>';

            if (data.length === 0) {
                formatSelect.innerHTML = '<option>Aucun format trouvé</option>';
                return;
            }

            data.forEach(format => {
                formatSelect.innerHTML += `
                    <option value="${format.id}">
                        ${format.name} (${format.players_count} joueurs)
                    </option>
                `;
            });

        })
        .catch(error => {
            console.error(error); // 🔥 debug
            formatSelect.innerHTML = '<option>Erreur de chargement</option>';
        });

});
</script>

</x-app-layout>