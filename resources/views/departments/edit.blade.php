<form method="POST" action="{{ route('departments.update', $department->id) }}">
    @csrf @method('PUT')

    <input name="name" value="{{ $department->name }}">

    <button>Update</button>
</form>