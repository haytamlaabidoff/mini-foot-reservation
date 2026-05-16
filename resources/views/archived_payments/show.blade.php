<x-app-layout>

<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">📦 Détails du Paiement Archivé</h1>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">

        <div>
            <strong>Staff:</strong>
            {{ $archive->staff->user->name }}
        </div>

        <div>
            <strong>Montant:</strong>
            {{ number_format($archive->amount, 2) }} MAD
        </div>

        <div>
            <strong>Mois:</strong>
            {{ $archive->month }}
        </div>

        <div>
            <strong>Paid At:</strong>
            {{ optional($archive->paid_at)->format('Y-m-d') }}
        </div>

        <div>
            <strong>Next Payment:</strong>
            {{ optional($archive->next_payment_at)->format('Y-m-d') }}
        </div>

        <div>
            <strong>Created At:</strong>
            {{ $archive->created_at->format('Y-m-d H:i') }}
        </div>

    </div>

    <div class="mt-6">
        <a href="{{ route('archived.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded">
            ⬅ Retour
        </a>
    </div>

</div>

</x-app-layout>