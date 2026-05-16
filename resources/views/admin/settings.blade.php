<x-app-layout>

<div class="max-w-3xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">
        ⚙️ Paramètres du Terrain
    </h2>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- NOM --}}
        <div class="mb-4">
            <label class="font-semibold">Nom du terrain</label>
            <input type="text" name="site_name"
                value="{{ $setting->site_name ?? '' }}"
                class="w-full border p-2 rounded mt-1">
        </div>

        {{-- TELEPHONE --}}
        <div class="mb-4">
            <label class="font-semibold">Téléphone</label>
            <input type="text" name="phone"
                value="{{ $setting->phone ?? '' }}"
                class="w-full border p-2 rounded mt-1">
        </div>

        {{-- EMAIL --}}
        <div class="mb-4">
            <label class="font-semibold">Email</label>
            <input type="email" name="email"
                value="{{ $setting->email ?? '' }}"
                class="w-full border p-2 rounded mt-1">
        </div>

        {{-- ADRESSE --}}
        <div class="mb-4">
            <label class="font-semibold">Adresse</label>
            <input type="text" name="address"
                value="{{ $setting->address ?? '' }}"
                class="w-full border p-2 rounded mt-1">
        </div>

        {{-- CITY --}}
        <div class="mb-4">
            <label class="font-semibold">Ville</label>
            <input type="text" name="city"
                value="{{ $setting->city ?? '' }}"
                class="w-full border p-2 rounded mt-1">
        </div>

        {{-- GOOGLE MAP --}}
        <div class="mb-4">
            <label class="font-semibold">Lien Google Maps</label>
            <input type="text" name="map_link"
                value="{{ $setting->map_link ?? '' }}"
                class="w-full border p-2 rounded mt-1">
        </div>

        {{-- LOGO --}}
        <div class="mb-4">
            <label class="font-semibold">Logo</label>
            <input type="file" name="logo"
                class="w-full border p-2 rounded mt-1">

            @if(isset($setting->logo))
                <img src="{{ asset('storage/'.$setting->logo) }}"
                     class="mt-3 h-20">
            @endif
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded w-full font-bold">
            💾 Enregistrer
        </button>

    </form>

</div>

</x-app-layout>