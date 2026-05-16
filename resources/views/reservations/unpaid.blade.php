<x-app-layout>

<div class="max-w-3xl mx-auto p-6 text-center">

    @if($reservation->payment_status === 'paid')

        <h1 class="text-3xl font-bold text-green-600">
            🟢 Paiement confirmé
        </h1>

        <p class="mt-4 text-lg">
            🎉 Votre réservation est validée avec succès
        </p>

    @else

        <h1 class="text-3xl font-bold text-red-600">
            🔴 Paiement requis
        </h1>

        <p class="mt-4 text-lg">
            ⚠️ Vous devez payer avant d’accéder au terrain
        </p>

    @endif

    <div class="mt-6 p-4 bg-gray-100 rounded">
        <p><b>Token:</b> {{ $reservation->qr_token }}</p>
        <p><b>Date:</b> {{ $reservation->reservation_date }}</p>
        <p><b>Statut:</b> {{ $reservation->payment_status }}</p>
    </div>

    <a href="/reservations"
       class="inline-block mt-6 bg-gray-700 text-white px-4 py-2 rounded">
        🔙 Retour
    </a>

</div>

</x-app-layout>