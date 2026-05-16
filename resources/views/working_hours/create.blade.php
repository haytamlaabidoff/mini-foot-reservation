<x-app-layout>

<div class="max-w-xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">➕ Create Working Hour</h2>

    <form method="POST" action="{{ route('working-hours.store') }}" class="space-y-4">
        @csrf

        {{-- DAYS --}}
        <div class="grid grid-cols-2 gap-2">
            @php
                $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            @endphp

            @foreach($days as $day)
            <label class="flex items-center gap-2 border p-2 rounded">
                <input type="checkbox" name="days[]" value="{{ $day }}">
                {{ $day }}
            </label>
            @endforeach
        </div>

        {{-- TIME --}}
        <input type="time" name="open_time" class="w-full border p-2 rounded">
        <input type="time" name="close_time" class="w-full border p-2 rounded">

        {{-- NOTE --}}
        <textarea name="note" class="w-full border p-2 rounded"
                  placeholder="Ex: cleaning / maintenance / special hours"></textarea>

        {{-- CLOSED --}}
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_closed">
            Closed
        </label>

        <button class="bg-green-600 text-white px-4 py-2 rounded w-full">
            Save
        </button>

    </form>

</div>

</x-app-layout>