<x-app-layout>

<div class="max-w-5xl mx-auto p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            📁 Departments
        </h1>

        <a href="{{ route('departments.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            ➕ Add Department
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-sm font-semibold text-gray-600">#</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Name</th>
                    <th class="p-3 text-sm font-semibold text-gray-600 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($departments as $d)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-3">{{ $d->id }}</td>

                    <td class="p-3 font-medium text-gray-800">
                        {{ $d->name }}
                    </td>

                    <td class="p-3 text-right flex justify-end gap-2">

                        <!-- EDIT -->
                        <a href="{{ route('departments.edit', $d->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                            ✏️ Edit
                        </a>

                        <!-- DELETE -->
                        <form method="POST"
                              action="{{ route('departments.destroy', $d->id) }}"
                              onsubmit="return confirm('Delete this department?')">
                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                🗑 Delete
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-6 text-center text-gray-500">
                        🚫 No departments found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

</x-app-layout>