<x-app-layout>
<div class="max-w-6xl mx-auto py-10 px-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Sports</h2>

        <a href="{{ route('sports.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg">
            + Ajouter Sport
        </a>
    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Slug</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sports as $sport)
                <tr class="border-b">
                    <td class="p-3">{{ $sport->id }}</td>
                    <td class="p-3">{{ $sport->name }}</td>
                    <td class="p-3">{{ $sport->slug }}</td>

                    <td class="p-3 flex gap-2">
                        <a href="{{ route('sports.edit', $sport->id) }}"
                           class="text-blue-600">Edit</a>

                        <form method="POST" action="{{ route('sports.destroy', $sport->id) }}">
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