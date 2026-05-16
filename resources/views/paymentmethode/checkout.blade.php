<x-app-layout>

<div class="max-w-xl mx-auto py-10">

    <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border">

        {{-- HEADER --}}
        <div class="bg-indigo-600 p-6 text-white">

            <h2 class="text-3xl font-bold">
                💳 Paiement Réservation
            </h2>

            <p class="text-indigo-100 mt-2">
                Paiement sécurisé avec Stripe
            </p>

        </div>

        {{-- CONTENT --}}
        <div class="p-6">

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 p-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR --}}
            @if(session('error'))
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            {{-- RESERVATION INFO --}}
            <div class="bg-gray-50 rounded-2xl p-5 border mb-6">

                <h3 class="font-bold text-lg mb-4">
                    📋 Détails Réservation
                </h3>

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            ⚽ Terrain
                        </span>

                        <span class="font-semibold">
                            {{ $reservation->terrain->name ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            📅 Date
                        </span>

                        <span class="font-semibold">
                            {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            🕒 Horaire
                        </span>

                        <span class="font-semibold">
                            {{ substr($reservation->start_time,0,5) }}
                            →
                            {{ substr($reservation->end_time,0,5) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            👤 Client
                        </span>

                        <span class="font-semibold">
                            {{ $reservation->client_name }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            💳 Méthode
                        </span>

                        <span class="font-semibold capitalize">
                            {{ $reservation->payment_method }}
                        </span>
                    </div>

                </div>

            </div>

            {{-- PRICE --}}
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5 mb-6">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-sm text-gray-500">
                            Total à payer
                        </p>

                        <h2 class="text-3xl font-bold text-indigo-700">
                            {{ $reservation->terrain->price_per_hour  }} DH/h
                        </h2>
                    </div>

                    <div class="text-5xl">
                        💳
                    </div>

                </div>

            </div>

            {{-- PAYMENT FORM --}}
            <form method="POST"
                  action="{{ route('payment.session', $reservation->id) }}">

                @csrf

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 transition text-white py-4 rounded-2xl text-lg font-bold shadow-lg">

                    🔒 Payer Maintenant

                </button>

            </form>

            {{-- TEST CARD --}}
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-2xl p-4">

                <h4 class="font-bold text-yellow-700 mb-2">
                    🧪 Carte de test Stripe
                </h4>

                <div class="text-sm text-gray-700 space-y-1">

                    <p>
                        <strong>Numéro :</strong>
                        4242 4242 4242 4242
                    </p>

                    <p>
                        <strong>Date :</strong>
                        12/34
                    </p>

                    <p>
                        <strong>CVC :</strong>
                        123
                    </p>

                    <p>
                        <strong>Pays :</strong>
                        Morocco
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</x-app-layout>