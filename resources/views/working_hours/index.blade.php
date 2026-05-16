<x-app-layout>

<div class="max-w-6xl mx-auto p-6">

    <div class="flex justify-between mb-6">
        <h2 class="text-2xl font-bold">🕒 Working Hours</h2>

        <a href="{{ route('working-hours.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded">
            + Add
        </a>
    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">

        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Days</th>
                    <th class="p-3">Open</th>
                    <th class="p-3">Close</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Note</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($hours as $h)
                <tr class="border-b">
                    <td class="p-3">
                        @foreach($h->days as $day)
                            <span class="px-2 py-1 bg-gray-200 text-xs rounded">
                                {{ $day }}
                            </span>
                        @endforeach
                    </td>

                    <td class="p-3">{{ $h->open_time }}</td>
                    <td class="p-3">{{ $h->close_time }}</td>

                    <td class="p-3">
                        @if($h->is_closed)
                            <span class="text-red-600">Closed</span>
                        @else
                            <span class="text-green-600">Open</span>
                        @endif
                    </td>

                    <td class="p-3 text-sm text-gray-600">
                        {{ $h->note ?? '-' }}
                    </td>

                    <td class="p-3 flex gap-2">
                        <a href="{{ route('working-hours.edit', $h->id) }}"
                           class="text-blue-600">Edit</a>

                        <form method="POST" action="{{ route('working-hours.destroy', $h->id) }}">
                            @csrf
                            @method('DELETE')
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