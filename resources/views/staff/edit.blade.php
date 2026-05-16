<x-app-layout>


<div class="max-w-4xl mx-auto p-6">

    <h1 class="text-xl font-bold mb-4">✏️ Edit Staff</h1>

    <form method="POST" action="{{ route('staff.update', $staff->id) }}">
        @csrf
        @method('PUT')

        <!-- POSTE -->
        <div>
            <label>Poste</label>
            <input type="text" name="poste" value="{{ $staff->poste }}" class="w-full border p-2">
        </div>

        <!-- DEPARTMENT -->
        <div class="mt-4">
            <label>Department</label>
            <input type="text" name="department" value="{{ $staff->department }}" class="w-full border p-2">
        </div>

        <!-- SALARY -->
        <div class="mt-4">
            <label>Salary</label>
            <input type="number" name="salary" value="{{ $staff->salary }}" class="w-full border p-2">
        </div>

        <!-- STATUS -->
        <div class="mt-4">
            <label>Status</label>
            <select name="status" class="w-full border p-2">
                <option value="active" {{ $staff->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $staff->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- BUTTON -->
        <div class="mt-6">
            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Update
            </button>
        </div>

    </form>

</div>

</x-app-layout>