<x-app-layout>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        👨‍💼 Liste des Admins
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($admins as $admin)

        <div class="bg-white shadow-lg rounded-2xl p-5 border hover:shadow-xl transition">

            <!-- Name -->
            <h2 class="text-lg font-bold text-gray-800">
                {{ $admin->user->name }} {{ $admin->user->prenom ?? '' }}
            </h2>

            <!-- Email -->
            <p class="text-sm text-gray-500">
                📧 {{ $admin->user->email }}
            </p>

            <hr class="my-3">

            <!-- Info -->
            <div class="space-y-1 text-sm">

                <p>📱 <span class="font-semibold">Phone:</span> {{ $admin->phone ?? 'N/A' }}</p>

                <p>🆔 <span class="font-semibold">CIN:</span> {{ $admin->cin ?? $admin->user->cin ?? 'N/A' }}</p>

                <p>🏠 <span class="font-semibold">Address:</span> {{ $admin->address ?? 'N/A' }}</p>

             

                <p>🧑‍💻 <span class="font-semibold">Role:</span>
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        {{ $admin->user->role }}
                    </span>
                </p>

            </div>

            <!-- Actions -->
            <div class="mt-4 flex gap-2">

                <a href="{{ route('admin.edit', $admin->id) }}"
                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm">
                    Edit
                </a>

                <form action="{{ route('admin.destroy', $admin->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
                        Delete
                    </button>
                </form>

            </div>

        </div>

        @endforeach

    </div>

</div>

</x-app-layout>