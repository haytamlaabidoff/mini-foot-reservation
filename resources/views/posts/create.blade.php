<x-app-layout>
<form method="POST" action="{{ route('posts.store') }}">
    @csrf

    <!-- Post Name -->
    <input
        name="name"
        placeholder="Post name"
        class="border p-2 w-full mb-2"
        required
    >

    <!-- Description -->
    <textarea
        name="description"
        placeholder="Description"
        class="border p-2 w-full mb-2"
    ></textarea>

    <!-- Department -->
    <select name="department_id" class="border p-2 w-full mb-2" required>
        <option value="">-- Select Department --</option>

        @foreach($departments as $dept)
            <option value="{{ $dept->id }}">
                {{ $dept->name }}
            </option>
        @endforeach
    </select>

    <!-- Button -->
    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Save
    </button>
</form>
</x-app-layout>