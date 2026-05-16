<x-app-layout>

<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">

    <h1 class="text-xl font-bold mb-6">
        💰 Ajouter Paiement
    </h1>

    <form method="POST" action="{{ route('payments.store') }}">
        @csrf

        <!-- STAFF (hidden or readonly) -->
        <input type="hidden" name="staff_id" value="{{ $staff->id }}">

        <div class="mb-4">
            <label class="text-sm font-medium">Staff</label>
            <div class="p-2 border rounded bg-gray-100">
                {{ $staff->user->name }}
            </div>
        </div>

        <!-- SALARY INFO -->
        <div class="mb-4">
            <label class="text-sm font-medium">Salaire de base</label>
            <div class="p-2 border rounded bg-gray-100">
                {{ $staff->salary }} DH
            </div>
        </div>

        <!-- AMOUNT (optional override) -->
        <div class="mb-4">
            <label class="text-sm font-medium">Montant (optionnel)</label>
            <input type="number" name="amount"
                   class="w-full border p-2 rounded"
                   placeholder="Laisser vide pour salaire automatique">
        </div>

        <!-- STATUS -->
        <div class="mb-4">
            <label class="text-sm font-medium">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="paid">Paid</option>
                <option value="pending">Pending</option>
                <option value="unpaid">Unpaid</option>
            </select>
        </div>

        <!-- NOTE -->
        <div class="mb-4">
            <label class="text-sm font-medium">Note</label>
            <textarea name="note" class="w-full border p-2 rounded"></textarea>
        </div>

        <!-- BUTTON -->
        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">
            💾 Save Payment
        </button>

    </form>

</div>

</x-app-layout>