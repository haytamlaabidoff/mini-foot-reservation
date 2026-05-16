<form method="POST" action="{{ route('posts.update', $post->id) }}">
    @csrf @method('PUT')

    <input name="name" value="{{ $post->name }}">

    <button>Update</button>
</form>