<form method="POST" action="{{ route('departments.store') }}">
    @csrf
    <input name="name" placeholder="Department name">
        <textarea name="description" placeholder="Description" class="border p-2 w-full mt-2"></textarea>

    <button>Save</button>
</form>