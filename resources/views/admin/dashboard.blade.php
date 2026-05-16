<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
            
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">
                    📊 Dashboard
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Gestion des réservations & terrains
                </p>
            </div>

            <div class="bg-white shadow px-4 py-2 rounded-xl text-sm text-gray-600">
                🕒 {{ now()->format('d M Y - H:i') }}
            </div>

        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen">

        <div class="max-w-7xl mx-auto px-4 space-y-6">

            <!-- WELCOME -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-500 rounded-2xl shadow-xl p-6 text-white">

                <div class="flex flex-col md:flex-row justify-between items-center gap-5">

                    <div>
                        <h3 class="text-2xl font-bold">
                            👋 Welcome back, {{ Auth::user()->name }}
                        </h3>

                        <p class="mt-2 text-green-100">
                            Role :
                            <span class="font-bold uppercase">
                                {{ Auth::user()->role }}
                            </span>
                        </p>
                    </div>

                    <div class="text-center md:text-right">
                        <p class="text-green-100">Mini Foot Platform</p>

                        <div class="flex items-center gap-2 justify-center md:justify-end mt-2">
                            <span class="w-3 h-3 bg-green-300 rounded-full animate-pulse"></span>
                            <span class="font-bold">SYSTEM ONLINE</span>
                        </div>
                    </div>

                </div>

            </div>

            <!-- STATS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                <!-- USERS -->
                <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-blue-500">

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Users</p>

                            <h3 class="text-4xl font-extrabold text-blue-600 mt-2">
                                {{ $users }}
                            </h3>
                        </div>

                        <div class="text-5xl">👤</div>
                    </div>

                </div>

                <!-- TERRAINS -->
                <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-green-500">

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Terrains</p>

                            <h3 class="text-4xl font-extrabold text-green-600 mt-2">
                                {{ $terrains }}
                            </h3>
                        </div>

                        <div class="text-5xl">⚽</div>
                    </div>

                </div>

                <!-- BOOKINGS -->
                <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-yellow-500">

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Today Bookings</p>

                            <h3 class="text-4xl font-extrabold text-yellow-500 mt-2">
                                {{ $reservationsToday }}
                            </h3>
                        </div>

                        <div class="text-5xl">📅</div>
                    </div>

                </div>

                <!-- REVENUE -->
                <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-purple-500">

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Revenue Today</p>

                            <h3 class="text-4xl font-extrabold text-purple-600 mt-2">
                                {{ number_format($revenueToday, 0) }} DH
                            </h3>
                        </div>

                        <div class="text-5xl">💰</div>
                    </div>

                </div>

            </div>

            <!-- STATUS + RESERVATIONS -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                <!-- STATUS -->
                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <h3 class="text-xl font-bold text-gray-800 mb-5">
                        📌 Status Overview
                    </h3>

                    <div class="space-y-4">

                        <div class="flex justify-between items-center bg-green-50 p-3 rounded-xl">
                            <span class="font-medium text-green-700">
                                ✅ Confirmed
                            </span>

                            <span class="font-bold text-green-700 text-lg">
                                {{ $confirmedReservations }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center bg-yellow-50 p-3 rounded-xl">
                            <span class="font-medium text-yellow-700">
                                ⏳ Pending
                            </span>

                            <span class="font-bold text-yellow-700 text-lg">
                                {{ $pendingPayments }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center bg-red-50 p-3 rounded-xl">
                            <span class="font-medium text-red-700">
                                ❌ Cancelled
                            </span>

                            <span class="font-bold text-red-700 text-lg">
                                {{ $cancelledReservations }}
                            </span>
                        </div>

                    </div>

                </div>

                <!-- RECENT -->
                <div class="bg-white rounded-2xl shadow-lg p-6 xl:col-span-2">

                    <div class="flex justify-between items-center mb-5">

                        <h3 class="text-xl font-bold text-gray-800">
                            📋 Upcoming Reservations
                        </h3>

                        <span class="text-sm text-gray-400">
                            Future matches only
                        </span>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead>

                                <tr class="border-b text-gray-500 text-sm">

                                    <th class="p-3 text-left">Client</th>

                                    <th class="p-3 text-left">Terrain</th>

                                    <th class="p-3 text-left">Date</th>

                                    <th class="p-3 text-left">Hour</th>

                                    <th class="p-3 text-left">Match</th>

                                    <th class="p-3 text-left">Payment</th>
                                    <th class="p-3 text-left">Remaining</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($latestReservations as $res)

                                    <tr class="border-b hover:bg-gray-50 transition">

                                        <!-- CLIENT -->
                                        <td class="p-3 font-semibold text-gray-700">
                                            {{ $res->client_name }}
                                        </td>

                                        <!-- TERRAIN -->
                                        <td class="p-3">
                                            <span class="bg-gray-100 px-3 py-1 rounded-full text-xs font-bold">
                                                {{ $res->terrain->name ?? '-' }}
                                            </span>
                                        </td>

                                        <!-- DATE -->
                                        <td class="p-3 font-medium">
                                            {{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}
                                        </td>

                                        <!-- TIME -->
                                        <td class="p-3">
                                            <div class="font-bold text-blue-600">
                                                {{ substr($res->start_time,0,5) }}
                                                →
                                                {{ substr($res->end_time,0,5) }}
                                            </div>
                                        </td>

                                        <!-- STATUS -->
                                        <td class="p-3">

                                            @if($res->status === 'confirmed')

                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    Confirmed
                                                </span>

                                            @elseif($res->status === 'cancelled')

                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    Cancelled
                                                </span>

                                            @else

                                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    Pending
                                                </span>

                                            @endif

                                        </td>

                                        <!-- PAYMENT -->
                                        <td class="p-3">

                                            <form method="POST"
                                                action="{{ route('admin.reservation.payment', $res->id) }}">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"

                                                    class="px-4 py-2 rounded-xl text-xs font-bold shadow-sm transition duration-300

                                                    {{ $res->payment_status === 'paid'

                                                        ? 'bg-green-100 text-green-700 hover:bg-red-100 hover:text-red-700'

                                                        : 'bg-red-100 text-red-700 hover:bg-green-100 hover:text-green-700'

                                                    }}">

                                                    @if($res->payment_status === 'paid')

                                                        ✔ Paid

                                                    @else

                                                        ✖ Not Paid

                                                    @endif

                                                </button>

                                            </form>

                                        </td>
<td class="p-3">

    @php
        $startDateTime = $res->reservation_date . ' ' . $res->start_time;
    @endphp

    <span
        class="countdown bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold"
        data-time="{{ $startDateTime }}">
    </span>

</td>
<script>

function updateCountdowns() {

    document.querySelectorAll('.countdown').forEach(el => {

        const target = new Date(el.dataset.time).getTime();

        const now = new Date().getTime();

        const diff = target - now;

        if (diff <= 0) {

            el.innerHTML = "Started";

            return;
        }

        const hours = Math.floor(diff / (1000 * 60 * 60));

        const minutes = Math.floor(
            (diff % (1000 * 60 * 60)) / (1000 * 60)
        );

        const seconds = Math.floor(
            (diff % (1000 * 60)) / 1000
        );

        // 🔥 WITH SECONDS
        el.innerHTML =
            hours + "h " +
            minutes + "m " +
            seconds + "s";

    });

}

updateCountdowns();

setInterval(updateCountdowns, 1000);

</script>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="6"
                                            class="text-center p-8 text-gray-400">

                                            No reservations available

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- CALENDAR -->
            <div class="bg-white rounded-2xl shadow-xl p-6">

                <div class="flex justify-between items-center mb-5">

                    <h3 class="text-2xl font-bold text-gray-800">
                        📅 Reservations Calendar
                    </h3>

                    <span class="text-sm text-gray-400">
                        Live planning
                    </span>

                </div>

                <div id="calendar"></div>

            </div>

        </div>

    </div>

    <!-- FULLCALENDAR -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>

    document.addEventListener('DOMContentLoaded', function () {

        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {

            initialView: 'timeGridWeek',

            height: 700,

            nowIndicator: true,

            slotMinTime: "00:00:00",

            slotMaxTime: "24:00:00",

            allDaySlot: false,

            expandRows: true,

            headerToolbar: {

                left: 'prev,next today',

                center: 'title',

                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'

            },

            events: {!! json_encode($calendarReservations) !!},

            eventDisplay: 'block',

            eventTimeFormat: {

                hour: '2-digit',

                minute: '2-digit',

                hour12: false

            },

            eventClick: function(info) {

                alert(
                    "⚽ " + info.event.title +
                    "\n🕒 " + info.event.start.toLocaleString()
                );

            }

        });

        calendar.render();

    });

    </script>

</x-app-layout>