<x-app-layout>

@php
    $prefilledDate = request('date');
    $prefilledSlot = request('slot');
@endphp

<div class="max-w-3xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">
        ⚽ Réserver: {{ $terrain->name }}
    </h2>

    {{-- 🔥 FORMAT INFO --}}
    @if($terrain->sportFormat)
        <div class="mb-4 p-4 bg-gray-50 rounded-xl border">
            <p class="font-bold text-green-600 text-lg">
                🎮 Format : {{ $terrain->sportFormat->name }}
            </p>

            <p class="text-sm text-gray-600 mt-1">
                👥 Nombre de joueurs : {{ $terrain->sportFormat->players_count }} joueurs
            </p>

            <p class="text-xs text-gray-400 mt-1">
                ⏱ Durée : {{ $terrain->sportFormat->duration }} min
            </p>
        </div>
    @endif

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            @foreach ($errors->all() as $error)
                <div>❌ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('booking.store') }}">
        @csrf

        <input type="hidden" name="terrain_id" value="{{ $terrain->id }}">
        <input type="hidden" name="selected_dates" id="selected_dates" value="[]">

        {{-- TYPE --}}
        <div class="mb-4">
            <label class="font-semibold">📌 Type réservation</label>

            <select id="type" name="type" class="w-full border p-2 rounded mt-1">
                <option value="">-- Choisir Type réservation --</option>
                <option value="simple">🟢 Simple</option>
                <option value="multi">📅 Multi Dates</option>
                <option value="fixe">🔁 Fixe</option>
            </select>
        </div>

        {{-- DATE --}}
        <div class="mb-4">
            <label class="font-semibold">📅 Date</label>

            <input type="date"
                   id="reservation_date"
                   name="reservation_date"
                   value="{{ $prefilledDate }}"
                   class="w-full border p-2 rounded mt-1">
        </div>

        {{-- SLOT --}}
        <div class="mb-4">
            <label class="font-semibold">🕒 Créneau</label>

            <select id="slot"
                    name="slot"
                    class="w-full border p-2 rounded mt-1">

                @if($prefilledSlot)
                    <option value="{{ $prefilledSlot }}" selected>
                        🟢 {{ $prefilledSlot }}
                    </option>
                @else
                    <option value="">-- Choisir --</option>
                @endif

            </select>
        </div>
<div class="mb-4">
    <label class="font-semibold">
        💳 Méthode de paiement
    </label>

    <select id="payment_method"
            name="payment_method"
            class="w-full border p-2 rounded mt-1">

        <option value="cash" selected>
            💵 Cash
        </option>

        <option value="card">
            💳 Carte Bancaire
        </option>

        <option value="online">
            🌐 Paiement En Ligne
        </option>

        <option value="stripe">
            💠 Stripe
        </option>

        <option value="paypal">
            🅿️ PayPal
        </option>

    </select>

    <div id="paymentMessage"
         class="hidden mt-3 p-3 rounded-lg bg-blue-50 text-blue-700 text-sm">
        🌐 Vous serez redirigé vers la page de paiement sécurisé.
    </div>
</div>

        {{-- ADD BUTTON --}}
        <button type="button" id="addBtn"
                class="bg-blue-600 text-white px-3 py-2 rounded">
            ➕ Ajouter
        </button>

        {{-- LIST --}}
        <div class="mt-4">
            <label class="font-semibold">📌 Sélection</label>
            <div id="box" class="flex flex-col gap-2 mt-2"></div>
        </div>

        {{-- FIXE MONTHS --}}
        <div class="mb-4 hidden" id="monthsBox">
            <label class="font-semibold">📆 Durée (mois)</label>

            <select name="months_duration"
                    class="w-full border p-2 rounded mt-1">
                @for($i=1;$i<=12;$i++)
                    <option value="{{ $i }}">{{ $i }} mois</option>
                @endfor
            </select>
        </div>
@php
    $user = auth()->user();
    $isStaff = $user->role === 'staff';

    $client = \App\Models\Client::where('user_id', $user->id)->first();
@endphp

<div class="mt-4">

    {{-- 👤 CLIENT CONNECTED --}}
    @if(!$isStaff)

        <input type="text"
               name="client_name"
               value="{{ $user->name }}"
               readonly
               class="w-full border p-2 rounded mb-2 bg-gray-100">

        <input type="text"
               name="client_phone"
               value="{{ $client->phone ?? '' }}"
               readonly
               class="w-full border p-2 rounded bg-gray-100">

    {{-- 👨‍💼 STAFF --}}
    @else

        <input type="text"
               name="client_name"
               placeholder="Nom client"
               class="w-full border p-2 rounded mb-2">

        <input type="text"
               name="client_phone"
               placeholder="Téléphone"
               class="w-full border p-2 rounded">

    @endif

</div>


        {{-- SUBMIT --}}
        <button type="submit"
                class="bg-green-600 text-white w-full p-3 rounded mt-4">
            ✅ Confirmer Réservation
        </button>


    </form>

</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const type = document.getElementById('type');
    const dateInput = document.getElementById('reservation_date');
    const slot = document.getElementById('slot');
    const addBtn = document.getElementById('addBtn');
    const box = document.getElementById('box');
    const hidden = document.getElementById('selected_dates');

    let selected = [];

    function render() {

        box.innerHTML = '';

        selected.forEach((item, i) => {

            let div = document.createElement('div');
            div.className = "flex justify-between bg-gray-100 p-2 rounded";

            div.innerHTML = `
                <span>📅 ${item.date} - 🕒 ${item.slot}</span>
                <button type="button">❌</button>
            `;

            div.querySelector('button').onclick = () => {
                selected.splice(i, 1);
                render();
            };

            box.appendChild(div);
        });

        hidden.value = JSON.stringify(selected);
    }

    addBtn.addEventListener('click', function () {

        if (!dateInput.value || !slot.value) return;

        selected.push({
            date: dateInput.value,
            slot: slot.value
        });

        render();
    });

});

document.addEventListener('DOMContentLoaded', function () {

    const paymentMethod = document.getElementById('payment_method');
    const paymentMessage = document.getElementById('paymentMessage');

    paymentMethod.addEventListener('change', function () {

        if (
            this.value === 'card' ||
            this.value === 'online' ||
            this.value === 'stripe' ||
            this.value === 'paypal'
        ) {

            paymentMessage.classList.remove('hidden');

        } else {

            paymentMessage.classList.add('hidden');

        }

    });

});

</script>
</x-app-layout>