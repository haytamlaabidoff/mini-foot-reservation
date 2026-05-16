<x-app-layout>

<div class="max-w-4xl mx-auto p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">
            ⚙️ Informations du Terrain
        </h2>

        <a href="{{ route('settings.index') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ✏️ Modifier
        </a>
    </div>

    @if(!$setting)
        <div class="bg-red-100 text-red-700 p-4 rounded">
            ❌ Aucune configuration trouvée
        </div>
    @else

    <div class="bg-white dark:bg-zinc-900 shadow rounded-xl p-6">

        {{-- LOGO + NAME --}}
        <div class="flex items-center gap-4 border-b pb-4 mb-4">

            @if($setting->logo)
                <img src="{{ asset('storage/'.$setting->logo) }}"
                     class="h-16 w-16 rounded-full object-cover border">
            @else
                <div class="h-16 w-16 bg-gray-200 rounded-full"></div>
            @endif

            <div>
                <h3 class="text-xl font-bold">
                    {{ $setting->site_name ?? 'Nom non défini' }}
                </h3>

                <p class="text-sm text-gray-500">
                    🏟️ Terrain principal
                </p>
            </div>

        </div>

        {{-- INFO GRID --}}
        <div class="grid grid-cols-2 gap-4">

            <div class="p-3 border rounded">
                <p class="text-gray-500 text-sm">📞 Téléphone</p>
                <p class="font-bold">{{ $setting->phone ?? '-' }}</p>
            </div>

            <div class="p-3 border rounded">
                <p class="text-gray-500 text-sm">📧 Email</p>
                <p class="font-bold">{{ $setting->email ?? '-' }}</p>
            </div>

            <div class="p-3 border rounded col-span-2">
                <p class="text-gray-500 text-sm">📍 Adresse</p>
                <p class="font-bold">
                    {{ $setting->address ?? '-' }}, {{ $setting->city ?? '' }}
                </p>
            </div>

            <div class="p-3 border rounded col-span-2">
           @if($setting->map_link)
    <div class="mt-3 rounded-lg overflow-hidden border">

        <iframe
            src="{{ $setting->map_link }}"
            width="100%"
            height="300"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>

    </div>
@else
    <span class="text-gray-400">Non défini</span>
@endif
            </div>

        </div>

    </div>

    @endif

</div>

</x-app-layout>