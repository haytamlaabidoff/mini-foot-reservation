<x-app-layout>
<div class="max-w-xl mx-auto py-10">

    <h2 class="text-2xl font-bold mb-6">Ajouter Sport</h2>

    <form method="POST" action="{{ route('sports.store') }}"
          class="bg-white p-6 rounded-xl shadow space-y-4">

        @csrf

        <div>
            <label>Nom</label>
            <input type="text" name="name"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Enregistrer
        </button>

    </form>

</div>
</x-app-layout>