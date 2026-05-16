<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="last-update" content="{{ $lastUpdate ?? now() }}">
        <title>FootBooking - Réservez votre terrain</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-gray-100 dark:bg-zinc-950 text-black dark:text-white">
        
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-gray-200 dark:border-zinc-800">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

        {{-- LOGO + NAME --}}
        <div class="flex items-center gap-3">

            @if($setting && $setting->logo)
                <img src="{{ asset('storage/'.$setting->logo) }}"
                     class="w-10 h-10 rounded-lg object-cover border">
            @else
                <div class="bg-green-600 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 21v-4m18 4v-4M10 21V4a2 2 0 114 0v17m-7-2a2 2 0 104 0m-4 0a2 2 0 114 0m6 2a2 2 0 10-4 0m4 0a2 2 0 11-4 0M9 7l.5 3m4.5-3l-.5 3"></path>
                    </svg>
                </div>
            @endif

            <span class="text-xl font-bold text-green-600 tracking-tight">
                {{ $setting->site_name ?? 'Foot' }}
            </span>

        </div>

        {{-- LOGIN --}}
        @if (Route::has('login'))
            <livewire:welcome.navigation />
        @endif

    </div>
</nav>
<main class="max-w-7xl mx-auto px-6 py-12">

{{-- HERO FILTER --}}
<section class="relative rounded-3xl overflow-hidden bg-zinc-900 min-h-[450px] flex items-center justify-center text-center mb-16 shadow-2xl">

    {{-- BG IMAGE --}}
    <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=2000"
         class="absolute inset-0 w-full h-full object-cover opacity-40">

    {{-- OVERLAY --}}
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 px-4 w-full max-w-6xl">

        {{-- TITLE --}}
        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 leading-tight">
            Réserve ton terrain,<br>
            domine le match.
        </h1>

        <p class="text-white/80 mb-10 text-lg max-w-2xl mx-auto">
            Trouvez rapidement un terrain disponible selon votre sport,
            votre format et votre date.
        </p>

        {{-- FILTER FORM --}}
        <form method="GET"
              action="{{ route('home') }}"
              class="bg-white dark:bg-zinc-900 p-6 rounded-3xl shadow-2xl grid grid-cols-1 md:grid-cols-5 gap-5 items-end">

            {{-- SPORT --}}
            <div class="text-left">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                    Sport
                </label>

                <select name="sport"
                        id="sportSelect"
                        class="w-full rounded-xl border p-3 dark:bg-zinc-800 dark:text-white">

                    <option value="">Tous les sports</option>

                    @foreach($sports as $sport)
                        <option value="{{ $sport->id }}"
                            {{ request('sport') == $sport->id ? 'selected' : '' }}>
                            {{ $sport->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- FORMAT --}}
            <div id="formatBox"
                 class="text-left {{ request('sport') ? '' : 'hidden' }}">

                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                    Format
                </label>

                <select name="format"
                        id="formatSelect"
                        class="w-full rounded-xl border p-3 dark:bg-zinc-800 dark:text-white">

                    <option value="">Tous les formats</option>

                    @foreach($sportFormats as $format)
                        <option value="{{ $format->id }}"
                            {{ request('format') == $format->id ? 'selected' : '' }}>
                            {{ $format->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- DATE --}}
            <div class="text-left">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                    Date
                </label>

                <input type="date"
                       name="date"
                       id="dateInput"
                       value="{{ request('date') }}"
                       min="{{ now()->format('Y-m-d') }}"
                       class="w-full rounded-xl border p-3 dark:bg-zinc-800 dark:text-white">
            </div>

            {{-- SLOT --}}
            <div class="text-left">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                    Créneau
                </label>

                <select id="slot"
                        name="slot"
                        class="w-full rounded-xl border p-3 dark:bg-zinc-800 dark:text-white">

                    <option value="">
                        -- Choisir --
                    </option>
                </select>
            </div>

           {{-- BUTTONS --}}
<div class="flex gap-3">

    {{-- SUBMIT --}}
    <button type="submit"
            class="w-full bg-green-600 hover:bg-green-700 transition text-white px-8 py-3 rounded-xl font-bold shadow-lg">
        🔍 Trouver un terrain
    </button>

    {{-- RESET --}}
    <button type="button"
            id="clearFilter"
            class="w-full bg-gray-200 hover:bg-gray-300 transition text-gray-800 px-8 py-3 rounded-xl font-bold shadow-lg">
        🧹 Vider
    </button>

</div>
        </form>

    </div>
</section>
<script>
document.getElementById('clearFilter').addEventListener('click', function () {

    // reset inputs
    document.getElementById('sportSelect').value = '';
    document.getElementById('formatSelect').value = '';
    document.getElementById('dateInput').value = '';
    document.getElementById('slot').value = '';

    // reload page clean (supprime GET filters)
    window.location.href = "{{ route('home') }}";
});
</script>

{{-- RESULT MESSAGE --}}
@if(request('sport') && request('format') && request('date') && request('slot'))

    <div class="mb-8 bg-green-100 border border-green-300 text-green-800 p-5 rounded-2xl shadow">

        <h2 class="font-bold text-xl mb-2">
            ✅ Résultat de recherche
        </h2>

        <p>
            Terrains disponibles le
            <strong>{{ \Carbon\Carbon::parse(request('date'))->format('d/m/Y') }}</strong>

            à

            <strong>{{ request('slot') }}</strong>

            pour le sport

            <strong>
                {{ optional($sports->where('id', request('sport'))->first())->name }}
            </strong>

            et le format

            <strong>
                {{ optional($sportFormats->where('id', request('format'))->first())->name }}
            </strong>
        </p>

    </div>

@endif

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dateInput = document.getElementById('dateInput');
    const slot = document.getElementById('slot');
    const sportSelect = document.getElementById('sportSelect');
    const formatSelect = document.getElementById('formatSelect');

    let terrainId = "{{ $firstTerrain?->id }}";

    // ===============================
    // LOAD HOURS
    // ===============================
    function loadHours(date) {

        if (!date || !terrainId) {

            slot.innerHTML = `
                <option value="">
                    Aucun terrain
                </option>
            `;

            return;
        }

        slot.innerHTML = `
            <option>
                Chargement...
            </option>
        `;

        fetch(`/terrain/${terrainId}/hours?date=${date}`)
            .then(response => response.json())

            .then(res => {

                slot.innerHTML = `
                    <option value="">
                        -- Choisir --
                    </option>
                `;

                // fermé
                if (res.closed) {

                    slot.innerHTML += `
                        <option disabled>
                            🔴 Fermé
                        </option>
                    `;

                    return;
                }

                // heures
                res.hours.forEach(h => {

                    if (h.status === 'reserved') {

                        slot.innerHTML += `
                            <option disabled>
                                🔴 ${h.slot}
                            </option>
                        `;

                    } else {

                        slot.innerHTML += `
                            <option value="${h.slot}">
                                🟢 ${h.slot}
                            </option>
                        `;
                    }

                });

            })

            .catch(error => {

                console.error(error);

                slot.innerHTML = `
                    <option disabled>
                        Erreur de chargement
                    </option>
                `;
            });
    }

    // ===============================
    // AUTO LOAD
    // ===============================
    if (dateInput.value) {
        loadHours(dateInput.value);
    }

    // ===============================
    // EVENTS
    // ===============================
    dateInput.addEventListener('change', function () {
        loadHours(this.value);
    });

});
</script>

    {{-- AJAX FORMAT --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const sportSelect = document.getElementById('sportSelect');
        const formatBox = document.getElementById('formatBox');
        const formatSelect = document.getElementById('formatSelect');

        sportSelect.addEventListener('change', function () {

            let sportId = this.value;

            // RESET
            formatSelect.innerHTML =
                '<option value="">Tous les formats</option>';

            // HIDE IF EMPTY
            if (!sportId) {

                formatBox.classList.add('hidden');
                return;
            }

            // SHOW
            formatBox.classList.remove('hidden');

            // LOAD FORMATS
            fetch('/sport-formats/' + sportId)

                .then(response => response.json())

                .then(data => {

                    data.forEach(format => {

                        formatSelect.innerHTML += `
                            <option value="${format.id}">
                                ${format.name}
                            </option>
                        `;
                    });

                })

                .catch(error => {

                    console.error('Erreur formats:', error);

                });

        });

    });
    </script>

    {{-- TITLE --}}
    <div class="flex items-center justify-between mb-8">

        <h2 class="text-2xl font-black uppercase">
            Terrains disponibles
        </h2>

        @if(request('date'))
            <span class="text-sm bg-green-100 text-green-700 px-4 py-2 rounded-xl font-semibold">
                📅 {{ request('date') }}
            </span>
        @endif

    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @forelse($terrains as $type => $groupTerrains)

            {{-- GROUP TITLE --}}
            <div class="col-span-full mt-6 mb-2">
                <h2 class="text-2xl font-black text-green-600 border-l-4 border-green-600 pl-3">
                    ⚽ {{ $type }}
                </h2>
            </div>

            @foreach($groupTerrains as $terrain)

                @php
                    $isBlocked = $terrain->terrain_condition === 'impraticable';
                @endphp

                <div class="bg-white dark:bg-zinc-900 rounded-3xl overflow-hidden shadow-xl border border-gray-100 dark:border-zinc-800">

                    {{-- IMAGE --}}
                    <div class="h-52 relative overflow-hidden">

                        <img src="https://images.unsplash.com/photo-1529900748604-07564a03e7a6?q=80&w=800"
                             class="w-full h-full object-cover hover:scale-105 transition duration-500">

                        {{-- STATUS --}}
                        <span class="absolute top-3 right-3 px-3 py-1 text-xs font-bold rounded-full text-white
                            {{ $terrain->status ? 'bg-green-600' : 'bg-red-600' }}">

                            {{ $terrain->status ? 'Disponible' : 'Indisponible' }}

                        </span>

                        {{-- CONDITION --}}
                        <span class="absolute top-3 left-3 px-3 py-1 text-xs font-bold rounded-full text-white
                            {{ $isBlocked ? 'bg-red-600' : 'bg-blue-600' }}">

                            {{ $isBlocked ? 'Impraticable' : 'Praticable' }}

                        </span>

                        {{-- CLOSED --}}
                        @if($isBlocked)
                            <div class="absolute inset-0 bg-black/70 flex items-center justify-center text-white font-black text-lg">
                                Fermé
                            </div>
                        @endif

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div>
                                <h3 class="font-black text-lg">
                                    {{ $terrain->name }}
                                </h3>

                                <p class="text-gray-500 text-sm mt-1">
                                    📍 Fès, Maroc
                                </p>
                            </div>

                            <span class="text-green-600 font-black text-lg whitespace-nowrap">
                                {{ $terrain->price_per_hour }} DH/h
                            </span>

                        </div>

                        {{-- SPORT --}}
                        <div class="mt-4 flex flex-wrap gap-2">

                            <span class="bg-gray-100 dark:bg-zinc-800 text-xs px-3 py-1 rounded-full font-semibold">
                                {{ optional($terrain->sport)->name ?? 'Sport' }}
                            </span>

                            <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-semibold">
                                {{ optional($terrain->sportFormat)->name ?? 'Format' }}
                            </span>

                        </div>

                     {{-- BUTTON --}}
@auth

    @php
        $hasFilter = request()->filled('date') && request()->filled('slot') && request()->filled('format');
    @endphp

    @if(!$isBlocked)

        @if($hasFilter)

            {{-- CAS FILTRÉ → réservation directe avec data --}}
            <a href="{{ route('booking.create', [
                'id' => $terrain->id,
                'date' => request('date'),
                'slot' => request('slot'),
                'format' => request('format')
            ]) }}"
               class="block mt-5 text-center bg-green-600 hover:bg-green-700 transition text-white py-3 rounded-2xl font-bold">
                Réserver maintenant
            </a>

        @else

            {{-- CAS NORMAL → page booking simple --}}
            <a href="{{ route('booking.create', $terrain->id) }}"
               class="block mt-5 text-center bg-green-600 hover:bg-green-700 transition text-white py-3 rounded-2xl font-bold">
                Réserver maintenant
            </a>

        @endif

    @else

        <button disabled
                class="w-full mt-5 bg-red-500 text-white py-3 rounded-2xl font-bold opacity-70 cursor-not-allowed">
            Indisponible
        </button>

    @endif

@else

    <button onclick="toggleAuthModal(true)"
            class="w-full mt-5 border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition py-3 rounded-2xl font-bold">
        Connexion
    </button>

@endauth

                    </div>

                </div>

            @endforeach

        @empty

            <div class="col-span-full text-center py-16">

                <div class="text-6xl mb-4">
                    ⚽
                </div>

                <h3 class="text-2xl font-black mb-2">
                    Aucun terrain disponible
                </h3>

                <p class="text-gray-500">
                    Essayez un autre sport, format ou une autre date.
                </p>

            </div>

        @endforelse

    </div>

</main>

{{-- AUTH MODAL --}}
<div id="authModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl w-96 text-center">
        <h2 class="font-bold text-xl mb-4">Connexion requise</h2>

        <a href="{{ route('login') }}" class="block bg-green-600 text-white py-2 rounded mb-2">
            Login
        </a>

        <a href="{{ route('register') }}" class="block border py-2 rounded">
            Register
        </a>

        <button onclick="toggleAuthModal(false)" class="mt-3 text-sm text-gray-500">
            Annuler
        </button>
    </div>
</div>

<script>
function toggleAuthModal(show){
    document.getElementById('authModal').classList.toggle('hidden', !show);
}
</script>


<script>
    function toggleAuthModal(show) {
        const modal = document.getElementById('authModal');
        if (show) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }
</script>

<script>
    function toggleAuthModal(show) {
        const modal = document.getElementById('authModal');
        if (show) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Fermer le modal si on clique à l'extérieur de la boîte blanche
    window.onclick = function(event) {
        const modal = document.getElementById('authModal');
        if (event.target == modal) {
            toggleAuthModal(false);
        }
    }
</script>
        </main>
<section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">

    {{-- MAP --}}
    <div class="lg:col-span-2 h-[420px] rounded-3xl overflow-hidden shadow-xl border border-gray-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 relative">

        <div class="absolute top-4 left-4 z-10 bg-white/90 dark:bg-zinc-800/90 px-3 py-1 rounded-full text-xs font-bold shadow">
            🗺️ Localisation
        </div>

        @if($setting && $setting->map_link)
            <iframe
                src="{!! $setting->map_link !!}"
                class="w-full h-full"
                style="border:0;"
                loading="lazy"
                allowfullscreen>
            </iframe>
        @else
            <div class="flex items-center justify-center h-full text-gray-400">
                🗺️ Map non disponible
            </div>
        @endif

    </div>

    {{-- CONTACT --}}
    <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl shadow-xl border border-gray-100 dark:border-zinc-800">

        <h3 class="text-lg font-black uppercase mb-6 flex items-center gap-2 text-gray-800 dark:text-white">
            📞 Contact & Infos
        </h3>

        {{-- PHONE --}}
        <div class="p-4 mb-4 rounded-2xl bg-gray-50 dark:bg-zinc-800">
            <p class="text-gray-500 text-xs">Téléphone</p>
            <p class="font-bold text-green-600 text-lg">
                {{ $setting->phone ?? 'Non défini' }}
            </p>
        </div>

        {{-- EMAIL --}}
        <div class="p-4 mb-4 rounded-2xl bg-gray-50 dark:bg-zinc-800">
            <p class="text-gray-500 text-xs">Email</p>
            <p class="font-semibold text-gray-800 dark:text-white break-all">
                {{ $setting->email ?? '-' }}
            </p>
        </div>

        {{-- ADDRESS --}}
        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-zinc-800">
            <p class="text-gray-500 text-xs">Adresse</p>
            <p class="font-semibold text-gray-800 dark:text-white">
                {{ $setting->address ?? '-' }}, {{ $setting->city ?? '' }}
            </p>
        </div>

        {{-- BUTTON CALL --}}
     @if(!empty($setting->phone))
    <a href="tel:{{ $setting->phone }}"
       class="mt-6 block text-center bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-2xl transition">
        📞 Appeler maintenant
    </a>
@endif
    </div>

</section>
<section class="max-w-5xl mx-auto mt-10">

    {{-- TITRE --}}
    <div class="text-center mb-6">
        <h2 class="text-3xl font-black uppercase">
            🕒 Horaires d'ouverture
        </h2>
        <p class="text-gray-500 text-sm">
            Consultez les horaires d’ouverture du terrain
        </p>
    </div>

    {{-- CARTE --}}
    <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl border border-gray-100 dark:border-zinc-800 overflow-hidden p-6">

        {{-- HEADER CLOCK --}}
        <div class="flex items-center justify-between mb-6">

            {{-- HEURE --}}
            <div>
                <p class="text-xs text-gray-500">Heure actuelle</p>

                <h2 id="digitalClock" class="text-3xl font-black text-green-600 tracking-widest">
                    --:--:--
                </h2>

                <p id="statusText" class="text-sm font-bold mt-1 text-gray-500">
                    Vérification...
                </p>
            </div>

            {{-- INDICATEUR --}}
            <div class="text-right">
                <span id="statusDot" class="inline-block w-3 h-3 rounded-full bg-gray-400 animate-pulse"></span>
            </div>

        </div>

        {{-- LISTE DES HORAIRES --}}
        <div class="space-y-3">

            @foreach($workingHours as $wh)

                @php
                    $days = is_array($wh->days)
                        ? $wh->days
                        : json_decode($wh->days, true);
                @endphp

               <div class="bg-gray-50 dark:bg-zinc-800 rounded-2xl overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-100 dark:bg-zinc-900 text-gray-600 dark:text-gray-300">
            <tr>
                <th class="text-left p-4 font-bold">Jours</th>
                <th class="text-right p-4 font-bold">Horaires</th>
            </tr>
        </thead>

        <tbody>

            @foreach($workingHours as $wh)

                @php
                    $days = is_array($wh->days)
                        ? $wh->days
                        : json_decode($wh->days, true);
                @endphp

                <tr class="border-b border-gray-200 dark:border-zinc-700 hover:bg-white/50 dark:hover:bg-zinc-700 transition">

                    {{-- LEFT: DAYS --}}
                    <td class="p-4">

                        <div class="flex flex-wrap gap-2">

                            @foreach($days ?? [] as $day)
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-white dark:bg-zinc-900">
                                    {{ $day }}
                                </span>
                            @endforeach

                        </div>

                    </td>

                    {{-- RIGHT: HOURS --}}
                    <td class="p-4 text-right">

                        @if($wh->is_closed)
                            <span class="text-red-500 font-bold">
                                🚫 Fermé
                            </span>
                        @else
                            <span class="text-green-600 font-black text-base">
                                {{ $wh->open_time }} - {{ $wh->close_time }}
                            </span>
                        @endif

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>
            @endforeach

        </div>

    </div>

</section>

{{-- SCRIPT HORLOGE + STATUT --}}
<script>
function updateClock() {
    const now = new Date();

    const time = now.toLocaleTimeString('fr-FR', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });

    document.getElementById('digitalClock').textContent = time;

    checkStatus();
}

function checkStatus() {

    let isOpen = @json($isOpen);

    const statusText = document.getElementById('statusText');
    const dot = document.getElementById('statusDot');

    if (isOpen) {
        statusText.textContent = "🟢 OUVERT MAINTENANT";
        statusText.className = "text-green-600 font-bold text-sm mt-1";
        dot.className = "w-3 h-3 rounded-full bg-green-500 animate-pulse";
    } else {
        statusText.textContent = "🔴 FERMÉ MAINTENANT";
        statusText.className = "text-red-500 font-bold text-sm mt-1";
        dot.className = "w-3 h-3 rounded-full bg-red-500";
    }
}

setInterval(updateClock, 1000);
updateClock();
</script>
{{-- FOOTER INFO --}}
<div class="mt-8 p-4 bg-green-50 dark:bg-green-900/20 rounded-2xl">

    <p class="text-xs text-green-700 dark:text-green-400 font-bold uppercase text-center">

        ⚽ {{ $setting->site_name ?? 'Terrain' }} - Service 7j/7

    </p>

</div>

<section class="bg-green-600 rounded-[2.5rem] p-10 md:p-16 text-white relative overflow-hidden shadow-2xl shadow-green-600/30 mb-12">
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">
        <div class="max-w-xl text-center md:text-left">
            <h2 class="text-4xl font-black uppercase italic mb-4">Besoin d'un tournoi ?</h2>
            <p class="text-green-100 font-medium">Contactez notre équipe pour des réservations de groupe, événements d'entreprise ou abonnements mensuels.</p>
        </div>
        
        <div class="flex flex-col gap-4 w-full md:w-auto">
            <a href="tel:+212667417622" class="flex items-center justify-center gap-3 bg-white text-black font-black px-8 py-4 rounded-2xl hover:bg-zinc-100 transition-all">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 004.815 4.815l.774-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                APPELER MAINTENANT
            </a>
            <a href="https://wa.me/212667417622" class="flex items-center justify-center gap-3 bg-zinc-900 text-white font-black px-8 py-4 rounded-2xl hover:bg-black transition-all">
                WHATSAPP DIRECT
            </a>
        </div>
    </div>
    <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-green-500 rounded-full opacity-50"></div>
</section>


      <footer class="bg-white dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-800 mt-20">
    <div class="max-w-7xl mx-auto px-6 py-14">
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            <!-- Logo & Description -->
            <div>
                <h2 class="text-2xl font-bold text-green-600">
                    FootBooking
                </h2>

                <p class="mt-4 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    منصة احترافية لحجز الملاعب الرياضية بسهولة وسرعة، مع إدارة متكاملة للمواعيد والحجوزات والدفع.
                </p>
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Navigation
                </h3>

                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="/" class="hover:text-green-600 transition">
                            Accueil
                        </a>
                    </li>

                    <li>
                        <a href="/terrains" class="hover:text-green-600 transition">
                            Terrains
                        </a>
                    </li>

                    <li>
                        <a href="/reservations" class="hover:text-green-600 transition">
                            Réservations
                        </a>
                    </li>

                    <li>
                        <a href="/contact" class="hover:text-green-600 transition">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Services
                </h3>

                <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <li>Réservation en ligne</li>
                    <li>Gestion des terrains</li>
                    <li>Paiement sécurisé</li>
                    <li>Support 7j/7</li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Contact
                </h3>

                <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <li>📍 Fès, Maroc</li>
                    <li>📞 +212 6 00 00 00 00</li>
                    <li>✉️ contact@footbooking.com</li>
                </ul>
            </div>

        </div>

        <!-- Bottom -->
        <div class="mt-12 pt-6 border-t border-gray-200 dark:border-zinc-800 flex flex-col md:flex-row items-center justify-between gap-4">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                © 2026 FootBooking. Tous droits réservés.
            </p>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }}
                • PHP v{{ PHP_VERSION }}
            </p>

        </div>
    </div>
</footer>
    </body>
</html>