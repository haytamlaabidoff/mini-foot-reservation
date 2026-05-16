<x-app-layout>

<div class="max-w-5xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">
        🎟️ Mes Réservations
    </h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($reservations->count() == 0)
        <div class="text-gray-500 text-center py-10">
            🚫 Aucune réservation trouvée
        </div>
    @else

        <div class="grid gap-4">

            @foreach($reservations as $res)

                @php
                    $dateTime = \Carbon\Carbon::parse($res->reservation_date.' '.$res->start_time);
                    $canCancel = now()->diffInHours($dateTime, false) >= 2;
                @endphp

                <div class="p-4 rounded-xl shadow flex justify-between items-center
                    {{ $res->status === 'cancelled' ? 'bg-gray-200 opacity-60' : 'bg-white dark:bg-zinc-900' }}">

                    {{-- INFO --}}
                    <div>
                        <h3 class="font-bold text-lg">
                            {{ $res->terrain->name }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            📅 {{ \Carbon\Carbon::parse($res->reservation_date)->translatedFormat('d/m/Y') }}
                        </p>

                        <p class="text-sm">
                            🕒 {{ $res->start_time }} → {{ $res->end_time }}
                        </p>

                        <p class="text-sm">
                            {{ ucfirst($res->type) }}
                        </p>

                        {{-- STATUS TEXT --}}
                        <p class="mt-2">
                            @if($res->status === 'cancelled')
                                <span class="text-red-600 font-bold">❌ Annulée</span>
                            @elseif($res->status === 'pending')
                                <span class="text-yellow-600 font-bold">⏳ Pending</span>
                            @else
                                <span class="text-green-600 font-bold">✅ Confirmed</span>
                            @endif
                        </p>

                        {{-- CANCEL BUTTON --}}
                        @if($res->status !== 'cancelled' && $canCancel)
                            <form action="{{ route('reservation.cancel', $res->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('PATCH')

                                <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">
                                    ❌ Annuler
                                </button>
                            </form>
                        @endif

                    </div>

                    {{-- RIGHT SIDE --}}
                    <div class="text-center">

                        @if($res->status !== 'cancelled')

                            <img
                                src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(url('/scan/'.$res->qr_token)) }}"
                            >

                            <a href="{{ route('reservation.pdf', $res->id) }}"
                               class="block mt-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                PDF
                            </a>

                        @else

                            <span class="text-red-500 font-bold">
                                🚫 Annulée
                            </span>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

</x-app-layout>