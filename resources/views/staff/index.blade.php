<x-app-layout>

<div class="max-w-6xl mx-auto p-6">
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

    <h1 class="text-2xl font-bold mb-4">👨‍💼 Liste des Staff</h1>

    <a href="{{ route('staff.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
        ➕ Ajouter Staff
    </a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mt-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full mt-6 border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Nom</th>
                <th class="p-2">Poste</th>
                <th class="p-2">Department</th>
                <th class="p-2">Salaire</th>
                <th class="p-2">Status</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($staff as $s)
            <tr class="border-t">

                <td class="p-2">{{ $s->user->name }}</td>

                <td class="p-2">
                    {{ $s->post?->name ?? '-' }}
                </td>

                <td class="p-2">
                    {{ $s->department?->name ?? '-' }}
                </td>

                <td class="p-2">{{ $s->salary }}</td>

                <td class="p-2">
                    <span class="px-2 py-1 rounded text-white 
                        {{ $s->status == 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $s->status }}
                    </span>
                </td>

              <td class="p-2 flex gap-2">

    <a href="{{ route('staff.edit', $s->id) }}"
       class="text-blue-500">
        Edit
    </a>

   <a href="{{ route('payments.create', $s->id) }}"
   class="text-green-600">
    💰 Payment
</a>

    <form action="{{ route('staff.destroy', $s->id) }}"
          method="POST"
          class="inline">
        @csrf
        @method('DELETE')
        <button class="text-red-500">
            Delete
        </button>
    </form>

</td>

            </tr>
            @endforeach
        </tbody>

    </table>

</div>
<hr>
   <!-- Carte ID -->
             <h1 class="text-xl font-bold text-gray-700 mb-4">Carte d'identité</h1>
            <div class="flex justify-center">
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border"
                     style="width: 85.6mm; height: 53.98mm;">

                    <div class="p-3 text-xs">
                        <h2 class="font-bold text-sm">CARTE NATIONALE</h2>
                        <p>Nom: EL ALAMI</p>
                        <p>Prénom: ZINEB</p>
                        <p>Date: 05/12/1983</p>
                    </div>

                </div>
            </div>


</x-app-layout>