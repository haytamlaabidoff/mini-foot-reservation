<x-app-layout>
<div class="max-w-xl mx-auto py-10">

    <h2 class="text-2xl font-bold mb-6">Ajouter Format</h2>

    <form method="POST" action="{{ route('sport-formats.store') }}"
          class="bg-white p-6 rounded-xl shadow space-y-4">

        @csrf

        <!-- Sport -->
        <div>
            <label>Sport</label>
            <select name="sport_id" class="w-full border rounded p-2" required>
                @foreach($sports as $sport)
                    <option value="{{ $sport->id }}">
                        {{ $sport->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Players -->
        <div>
            <label>Nombre de joueurs</label>
            <input type="number" name="players_count"
                   class="w-full border rounded p-2"
                   placeholder="ex: 10"
                   required>
        </div>

        <!-- Duration -->
        <div>
            <label>Durée (min)</label>
            <input type="number" name="duration"
                   class="w-full border rounded p-2"
                   value="60">
        </div>

        <!-- Price -->
        <div>
            <label>Prix par défaut</label>
            <input type="number" name="default_price"
                   class="w-full border rounded p-2">
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Enregistrer
        </button>

    </form>

</div>
</x-app-layout>