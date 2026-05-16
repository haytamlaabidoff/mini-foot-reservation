<x-app-layout>
<div class="max-w-6xl mx-auto py-10 px-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Sport Formats</h2>

        <a href="{{ route('sport-formats.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg">
            + Ajouter Format
        </a>
    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Sport</th>
                    <th class="p-3">Format</th>
                    <th class="p-3">Joueurs</th>
                    <th class="p-3">Durée</th>
                    <th class="p-3">Prix</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($formats as $format)
                <tr class="border-b">
                    <td class="p-3">{{ $format->sport->name }}</td>
                    <td class="p-3">{{ $format->name }}</td>
                    <td class="p-3">{{ $format->players_count }}</td>
                    <td class="p-3">{{ $format->duration }} min</td>
                    <td class="p-3">{{ $format->default_price }}</td>

                    <td class="p-3 flex gap-2">
                        <a href="{{ route('sport-formats.edit', $format->id) }}"
                           class="text-blue-600">Edit</a>

                        <form method="POST" action="{{ route('sport-formats.destroy', $format->id) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>
</x-app-layout>