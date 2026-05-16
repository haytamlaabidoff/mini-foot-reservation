<x-app-layout>

<div class="flex justify-center gap-8 py-10 bg-gray-100">

    <!-- FRONT CARD -->
    <div class="relative bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-2xl overflow-hidden border"
         style="width: 85.6mm; height: 53.98mm;">

        <!-- Top bar -->
        <div class="h-2 bg-blue-600"></div>

        <div class="p-3 h-full flex flex-col justify-between">

            <!-- Header -->
      <div class="flex items-center gap-3">

    <!-- STAFF IMAGE -->
    <div class="shrink-0">
        @if($staff->image)
            <img src="{{ asset('storage/'.$staff->image) }}"
                 class="w-10 h-10 rounded-full object-cover border-2 border-blue-500 shadow">
        @else
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold border border-blue-300">
                {{ strtoupper(substr($staff->user->name, 0, 1)) }}
            </div>
        @endif
    </div>

    <!-- TEXT INFO -->
    <div class="leading-tight">
        <h2 class="font-bold text-[11px] text-gray-800 uppercase tracking-wide">
            Staff Identity Card
        </h2>

        <p class="text-[10px] text-gray-500">
            Employee ID: <span class="font-semibold text-gray-700">{{ $staff->employee_code }}</span>
        </p>
    </div>

</div>

            <!-- Info -->
            <div class="text-[10px] space-y-1 text-gray-700">
                <p><span class="font-semibold">Nom:</span> {{ $staff->user->name }}</p>
                <p><span class="font-semibold">Email:</span> {{ $staff->user->email }}</p>
                <p><span class="font-semibold">CIN:</span> {{ $staff->cin }}</p>
                <p><span class="font-semibold">Téléphone:</span> {{ $staff->phone ?? '-' }}</p>
            </div>

            <!-- Footer -->
            <div class="flex justify-between items-end text-[9px] text-gray-500">
                <span>{{ $staff->department->name ?? '-' }}</span>
                <span class="text-blue-600 font-bold">ACTIVE</span>
            </div>

        </div>
    </div>


    <!-- BACK CARD -->
    <div class="relative shadow-xl rounded-2xl overflow-hidden border text-white"
         style="width: 85.6mm; height: 53.98mm;">

        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-blue-900"></div>

        <div class="relative p-4 h-full flex flex-col items-center justify-center text-center">

            <!-- Logo -->
           <!-- Logo (SMALL PROFESSIONAL SIZE) -->
<div class="mb-2">
    @if($setting && $setting->logo)
        <img src="{{ asset('storage/'.$setting->logo) }}"
             class="w-10 h-10 rounded-full object-cover border border-white shadow-sm">
    @else
        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-xs">
            🏟️
        </div>
    @endif
</div>

            <!-- Brand -->
            <h2 class="text-sm text-green-600 font-bold tracking-wide uppercase">
                {{ $setting->site_name ?? 'Terrain System' }}
            </h2>

            <p class="text-[10px] text-gray-600 opacity-80 mt-1">
                Staff Identification Card
            </p>

         
        </div>
    </div>

</div>

</x-app-layout>