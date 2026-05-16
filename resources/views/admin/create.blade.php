<x-app-layout>

<div class="p-6 max-w-xl mx-auto">

    <h2 class="text-xl mb-4">Créer Admin</h2>

    <form method="POST" action="{{ route('admin.store') }}">
        @csrf
          {{-- ERRORS --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            @foreach ($errors->all() as $error)
                <div>❌ {{ $error }}</div>
            @endforeach
        </div>
    @endif
        <!-- Nom -->
        <input type="text" name="name" placeholder="Nom"
            class="w-full border p-2 mb-2" required>

        <!-- Prenom -->
        <input type="text" name="prenom" placeholder="Prénom"
            class="w-full border p-2 mb-2" required>

        <!-- Email -->
        <input type="email" name="email" placeholder="Email"
            class="w-full border p-2 mb-2" required>

        <!-- Phone -->
        <input type="text" name="phone" placeholder="Téléphone"
            class="w-full border p-2 mb-2">

        <!-- CIN -->
        <input type="text" name="cin" placeholder="CIN"
            class="w-full border p-2 mb-2">

        <!-- Password -->
        <input type="password" name="password" placeholder="Password"
            class="w-full border p-2 mb-2" required>


            <input type='textarea' name='address' placeholder='Address  ' class="w-full border p-2 mb-2">   

        <button class="bg-green-500 text-white px-4 py-2 mt-3 w-full">
            Créer Admin
        </button>

    </form>

</div>

</x-app-layout>