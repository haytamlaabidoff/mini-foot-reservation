<x-app-layout>

<div class="max-w-5xl mx-auto p-6">

    <!-- Title -->
    <h1 class="text-2xl font-bold mb-6">📋 Posts</h1>

    <!-- Add Button -->
    <a href="{{ route('posts.create') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        ➕ Add Post
    </a>

    <!-- Table -->
    <div class="mt-6 overflow-x-auto">
        <table class="w-full border border-gray-200">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Description</th>
                    <th class="p-3 text-left">Department</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($posts as $p)
                    <tr class="border-t">

                        <!-- Name -->
                        <td class="p-3">
                            {{ $p->name }}
                        </td>

                        <!-- Description -->
                        <td class="p-3">
                            {{ $p->description ?? '-' }}
                        </td>

                        <!-- Department -->
                        <td class="p-3">
                            {{ $p->department->name ?? 'No department' }}
                        </td>

                        <!-- Actions -->
                        <td class="p-3 flex gap-2">

                            <a href="{{ route('posts.edit', $p->id) }}"
                               class="bg-yellow-400 px-3 py-1 rounded text-white">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('posts.destroy', $p->id) }}"
                                  onsubmit="return confirm('Are you sure?')">

                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 px-3 py-1 rounded text-white">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

</x-app-layout>