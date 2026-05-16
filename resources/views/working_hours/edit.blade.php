<x-app-layout>

<div class="max-w-xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">✏️ Edit Working Hour</h2>

    <form method="POST" action="{{ route('working-hours.update', $hour->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <input type="text" name="day" value="{{ $hour->day }}"
               class="w-full border p-2 rounded">

        <input type="time" name="open_time" value="{{ $hour->open_time }}"
               class="w-full border p-2 rounded">

        <input type="time" name="close_time" value="{{ $hour->close_time }}"
               class="w-full border p-2 rounded">

        <label>
            <input type="checkbox" name="is_closed" {{ $hour->is_closed ? 'checked' : '' }}>
            Closed
        </label>

        <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">
            Update
        </button>
    </form>

</div>

</x-app-layout>