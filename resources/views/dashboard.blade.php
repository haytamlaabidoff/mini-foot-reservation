<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                ⚡ Dashboard
            </h2>

            <div class="text-sm text-gray-500">
                {{ now()->format('d M Y - H:i') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- WELCOME -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-500 rounded-2xl shadow-xl p-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                    <div>
                        <h2 class="text-3xl font-bold">
                            Welcome back, {{ Auth::user()->name }} 👋
                        </h2>

                        <p class="mt-2 text-green-100">
                            Role:
                            <span class="font-semibold uppercase">
                                {{ Auth::user()->role === 'user' ? 'Client' : Auth::user()->role }}
                            </span>
                        </p>

                        <p class="mt-1 text-green-100">
                            Here's your football reservation platform overview.
                        </p>
                    </div>

                    <div class="hidden md:block">
                        <div class="bg-white/20 backdrop-blur-md rounded-2xl p-5 text-center">
                            <div class="text-5xl">⚽</div>
                            <div class="mt-2 font-semibold">
                                Mini Foot Reservation
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- STATS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

                <!-- USERS -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:scale-[1.02] transition">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">
                                Total Users
                            </p>

                            <h3 class="text-4xl font-bold text-blue-600 mt-2">
                                {{ $users ?? 0 }}
                            </h3>
                        </div>

                        <div class="text-5xl">
                            👥
                        </div>
                    </div>

                    <div class="mt-4 text-sm text-gray-400">
                        Registered accounts
                    </div>

                </div>

                <!-- TERRAINS -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:scale-[1.02] transition">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">
                                Total Terrains
                            </p>

                            <h3 class="text-4xl font-bold text-green-600 mt-2">
                                {{ $terrains ?? 0 }}
                            </h3>
                        </div>

                        <div class="text-5xl">
                            ⚽
                        </div>
                    </div>

                    <div class="mt-4 text-sm text-gray-400">
                        Active terrains
                    </div>

                </div>

                <!-- RESERVATIONS -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 hover:scale-[1.02] transition">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">
                                Reservations Today
                            </p>

                            <h3 class="text-4xl font-bold text-yellow-500 mt-2">
                                {{ $reservationsToday ?? 0 }}
                            </h3>
                        </div>

                        <div class="text-5xl">
                            📅
                        </div>
                    </div>

                    <div class="mt-4 text-sm text-gray-400">
                        Today's bookings
                    </div>

                </div>

                <!-- REVENUE -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500 hover:scale-[1.02] transition">

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">
                                Revenue Today
                            </p>

                            <h3 class="text-4xl font-bold text-red-500 mt-2">
                                {{ $revenueToday ?? 0 }} DH
                            </h3>
                        </div>

                        <div class="text-5xl">
                            💰
                        </div>
                    </div>

                    <div class="mt-4 text-sm text-gray-400">
                        Paid reservations
                    </div>

                </div>

            </div>

            <!-- SECOND STATS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- CONFIRMED -->
                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-gray-700">
                            Confirmed
                        </h3>

                        <span class="text-3xl">✅</span>
                    </div>

                    <div class="mt-5">
                        <h2 class="text-5xl font-bold text-green-600">
                            {{ $confirmedReservations ?? 0 }}
                        </h2>
                    </div>

                </div>

                <!-- PENDING -->
                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-gray-700">
                            Pending Payments
                        </h3>

                        <span class="text-3xl">⏳</span>
                    </div>

                    <div class="mt-5">
                        <h2 class="text-5xl font-bold text-yellow-500">
                            {{ $pendingPayments ?? 0 }}
                        </h2>
                    </div>

                </div>

                <!-- CANCELLED -->
                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-gray-700">
                            Cancelled
                        </h3>

                        <span class="text-3xl">❌</span>
                    </div>

                    <div class="mt-5">
                        <h2 class="text-5xl font-bold text-red-500">
                            {{ $cancelledReservations ?? 0 }}
                        </h2>
                    </div>

                </div>

            </div>

            <!-- RECENT RESERVATIONS -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

                <div class="p-6 border-b bg-gray-50">
                    <h3 class="text-xl font-bold text-gray-800">
                        📋 Recent Reservations
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                    Client
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                    Terrain
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                    Date
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                    Heure
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                    Status
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">

                            @forelse($latestReservations ?? [] as $reservation)

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        {{ $reservation->client_name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $reservation->terrain->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $reservation->reservation_date }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $reservation->start_time }}
                                        -
                                        {{ $reservation->end_time }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if($reservation->status === 'confirmed')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                                Confirmed
                                            </span>
                                        @elseif($reservation->status === 'cancelled')
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                                Cancelled
                                            </span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                                Pending
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        No reservations found
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>