<x-app-layout>

<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">💰 Payments Staff</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full border-collapse">

            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">Staff</th>
                    <th class="p-3">Montant</th>
                    <th class="p-3">Mois</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Paid At</th>
                    <th class="p-3">Next Payment</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($payments as $p)

                    @php
                        $canPay = $p->next_payment_at
                            && now()->greaterThanOrEqualTo($p->next_payment_at);
                    @endphp

                    <tr class="border-t hover:bg-gray-50">

                        {{-- STAFF --}}
                        <td class="p-3 font-medium">
                            {{ $p->staff->user->name }}
                        </td>

                        {{-- AMOUNT --}}
                        <td class="p-3">
                            {{ number_format($p->amount, 2) }} MAD
                        </td>

                        {{-- MONTH --}}
                        <td class="p-3">
                            {{ $p->month }}
                        </td>

                        {{-- STATUS --}}
                        <td class="p-3">
                            @if($p->status === 'paid')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                    Paid
                                </span>
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">
                                    Non Paid
                                </span>
                            @endif
                        </td>

                        {{-- PAID DATE --}}
                        <td class="p-3">
                            {{ $p->paid_at ? $p->paid_at->format('Y-m-d') : '-' }}
                        </td>

                        {{-- NEXT PAYMENT --}}
                        <td class="p-3">
                            @if($p->next_payment_at)
                                <span class="text-gray-700">
                                    {{ $p->next_payment_at->format('Y-m-d') }}
                                </span>
                            @else
                                -
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td class="p-3">

                            @if($p->status === 'paid')

                                <span class="text-green-600 font-semibold">
                                    ✔ Completed
                                </span>

                            @elseif($canPay)

                                <form method="POST" action="{{ route('payments.pay', $p->id) }}">
                                    @csrf
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded">
                                        Pay Now
                                    </button>
                                </form>

                            @else

                                <span class="text-gray-500 text-sm">
                                    Waiting until {{ optional($p->next_payment_at)->format('Y-m-d') }}
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>
    </div>

</div>

</x-app-layout>