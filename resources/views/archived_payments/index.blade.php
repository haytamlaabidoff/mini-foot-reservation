<x-app-layout>

<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">📦 Archived Payments</h1>

    <table class="w-full border bg-white shadow">

        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Staff</th>
                <th class="p-3">Amount</th>
                <th class="p-3">Month</th>
                <th class="p-3">Paid At</th>
                <th class="p-3">Next Payment</th>
                <th class="p-3">Created At</th>
            </tr>
        </thead>

        <tbody>

            @foreach($archives as $a)
            <tr class="border-t hover:bg-gray-50">

                <td class="p-3">
                    {{ $a->staff->user->name }}
                </td>

                <td class="p-3">
                    {{ number_format($a->amount, 2) }} MAD
                </td>

                <td class="p-3">
                    {{ $a->month }}
                </td>

                <td class="p-3">
                    {{ optional($a->paid_at)->format('Y-m-d') }}
                </td>

                <td class="p-3">
                    {{ optional($a->next_payment_at)->format('Y-m-d') }}
                </td>

                <td class="p-3">
                    {{ $a->created_at->format('Y-m-d H:i') }}
                </td>

            </tr>
            @endforeach

        </tbody>

    </table>

</div>

</x-app-layout>