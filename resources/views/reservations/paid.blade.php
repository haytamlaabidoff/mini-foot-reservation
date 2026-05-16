<x-app-layout>

<div class="max-w-4xl mx-auto p-6">

    <!-- CARD PRINCIPALE -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

        <!-- HEADER STATUS -->
        <div class="p-6 text-center border-b
            @if($reservation->payment_status === 'paid')
                bg-green-50
            @else
                bg-red-50
            @endif
        ">

            @if($reservation->payment_status === 'paid')
                <h1 class="text-3xl font-bold text-green-600">
                    🟢 Paiement confirmé
                </h1>
                <p class="text-gray-600 mt-2">
                    Réservation validée avec succès
                </p>
            @else
                <h1 class="text-3xl font-bold text-red-600">
                    🔴 Paiement requis
                </h1>
                <p class="text-gray-600 mt-2">
                    Vous devez régler avant l’accès au terrain
                </p>
            @endif

        </div>

        <!-- BODY -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- CLIENT -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h2 class="text-sm text-gray-500 mb-2">👤 Client</h2>
                <p class="font-semibold text-gray-800">{{ $reservation->client_name }}</p>
                <p class="text-gray-600">{{ $reservation->client_phone }}</p>
            </div>

            <!-- TERRAIN -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h2 class="text-sm text-gray-500 mb-2">⚽ Terrain</h2>
                <p class="font-semibold text-gray-800">
                    {{ $reservation->terrain->name ?? '-' }}
                </p>
            </div>

            <!-- MATCH -->
            <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                <h2 class="text-sm text-gray-500 mb-3">📅 Match</h2>

                <div class="flex flex-col md:flex-row justify-between">
                    <p>
                        📆 Date :
                        <span class="font-semibold">
                            {{ $reservation->reservation_date }}
                        </span>
                    </p>

                    <p>
                        🕒 Horaire :
                        <span class="font-semibold">
                            {{ $reservation->start_time }} → {{ $reservation->end_time }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- PAYMENT -->
            <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                <h2 class="text-sm text-gray-500 mb-3">💳 Paiement</h2>

                <div class="flex flex-col md:flex-row justify-between gap-4">

                    <p>
                        Statut :
                        @if($reservation->payment_status === 'paid')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-bold">
                                Paid
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-bold">
                                Not Paid
                            </span>
                        @endif
                    </p>

                    <p>
                        📅 Date paiement :
                        <span class="font-semibold text-gray-700">
                            {{ $reservation->payment_status === 'paid' ? $reservation->updated_at->format('Y-m-d') : '-' }}
                        </span>
                    </p>

                    <p>
                        ⏰ Heure paiement :
                        <span class="font-semibold text-gray-700">
                            {{ $reservation->payment_status === 'paid' ? $reservation->updated_at->format('H:i') : '-' }}
                        </span>
                    </p>

                </div>
            </div>

            <!-- TOKEN -->
            <div class="bg-gray-900 text-white rounded-xl p-4 md:col-span-2">
                <h2 class="text-sm text-gray-300 mb-2">🔐 QR Token</h2>
                <p class="font-mono text-sm break-all">
                    {{ $reservation->qr_token }}
                </p>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="p-6 border-t text-center">
            <a href="/reservations"
               class="inline-block bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg transition">
                🔙 Retour
            </a>
        </div>

    </div>

</div>

</x-app-layout>