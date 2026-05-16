<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Terrain;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\GeneralSetting;
use App\Models\WorkingHour;
use Carbon\Carbon;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;
class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('terrain')
            ->where('user_id', Auth::id())
            ->orderBy('reservation_date', 'desc')
            ->get();
           



        return view('reservations.index', compact('reservations'));
    }
public function create($id)
{
    $terrain = Terrain::findOrFail($id);

    $reservations = Reservation::where('terrain_id', $id)->get();
    $workingHours = WorkingHour::all();

    $hours = [];

    // -------------------------
    // 1. GENERATE ALL HOURS
    // -------------------------
    foreach ($workingHours as $wh) {

        if ($wh->is_closed) continue;

        $start = (int) Carbon::parse($wh->open_time)->format('H');
        $end   = (int) Carbon::parse($wh->close_time)->format('H');

        // NORMAL DAY
        if ($start < $end) {

            for ($h = $start; $h <= $end; $h++) {
                $hours[] = sprintf('%02d:00', $h);
            }

        } else {

            // OVERNIGHT (ex: 17 -> 02)
            for ($h = $start; $h <= 23; $h++) {
                $hours[] = sprintf('%02d:00', $h);
            }

            for ($h = 0; $h <= $end; $h++) {
                $hours[] = sprintf('%02d:00', $h);
            }
        }
    }

    $hours = array_values(array_unique($hours));

    // -------------------------
    // 2. START HOURS (REMOVE LAST SLOT SAFE)
    // -------------------------
    $startHours = $hours;

    // ❌ remove last hour so it can't be used as START
    array_pop($startHours);

    // -------------------------
    // 3. BLOCK RESERVED HOURS
    // -------------------------
    $blockedHours = [];

    foreach ($reservations as $res) {

        if (!$res->start_time || !$res->end_time) continue;

        $start = (int) Carbon::parse($res->start_time)->format('H');
        $end   = (int) Carbon::parse($res->end_time)->format('H');

        if ($start < $end) {

            for ($h = $start; $h < $end; $h++) {
                $blockedHours[] = sprintf('%02d:00', $h);
            }

        } else {

            for ($h = $start; $h <= 23; $h++) {
                $blockedHours[] = sprintf('%02d:00', $h);
            }

            for ($h = 0; $h < $end; $h++) {
                $blockedHours[] = sprintf('%02d:00', $h);
            }
        }
    }

    $blockedHours = array_values(array_unique($blockedHours));

    // -------------------------
    // 4. RETURN VIEW
    // -------------------------
    return view('reservations.create', compact(
        'terrain',
        'reservations',
        'hours',        // END TIME
        'startHours',   // START TIME SAFE
        'blockedHours'
    ));
}
public function getHours(Request $request, $id)
{
    $date = $request->date;
    $dayName = Carbon::parse($date)->format('l');

    $now = Carbon::now();
    $selectedDate = Carbon::parse($date);
    $isToday = $selectedDate->isToday();
    $currentHour = (int) $now->format('H');

    $workingHours = WorkingHour::whereJsonContains('days', $dayName)->get();

    if ($workingHours->isEmpty()) {
        return response()->json([
            'closed' => true,
            'hours' => []
        ]);
    }

    // =========================
    // 1. BUILD WORKING HOURS
    // =========================
    $availableHours = [];

    foreach ($workingHours as $wh) {

        $start = (int) Carbon::parse($wh->open_time)->format('H');
        $end   = (int) Carbon::parse($wh->close_time)->format('H');

        if ($start < $end) {
            for ($h = $start; $h < $end; $h++) {
                $availableHours[] = $h;
            }
        } else {
            for ($h = $start; $h < 24; $h++) {
                $availableHours[] = $h;
            }
            for ($h = 0; $h < $end; $h++) {
                $availableHours[] = $h;
            }
        }
    }

    $availableHours = array_unique($availableHours);

    // =========================
    // 2. RESERVATIONS
    // =========================
    $reservations = Reservation::where('terrain_id', $id)
        ->where('reservation_date', $date)
        ->where('status', '!=', 'cancelled')
        ->get();

    $blocked = [];

    foreach ($reservations as $res) {

        $start = (int) Carbon::parse($res->start_time)->format('H');
        $end   = (int) Carbon::parse($res->end_time)->format('H');

        if ($start < $end) {
            for ($h = $start; $h < $end; $h++) {
                $blocked[] = $h;
            }
        } else {
            for ($h = $start; $h < 24; $h++) {
                $blocked[] = $h;
            }
            for ($h = 0; $h < $end; $h++) {
                $blocked[] = $h;
            }
        }
    }

    $blocked = array_unique($blocked);

    // =========================
    // 3. RESULT
    // =========================
    $result = [];

    foreach ($availableHours as $h) {

        $next = ($h + 1) % 24;

        // réservé
        $isReserved = in_array($h, $blocked);

        // passé (si aujourd’hui)
        $isPast = $isToday && $h < $currentHour;

        $result[] = [
            'slot' => sprintf('%02d:00 - %02d:00', $h, $next),
            'status' => ($isReserved || $isPast) ? 'reserved' : 'available'
        ];
    }

    // sort
    usort($result, function ($a, $b) {
        return intval(explode(':', $a['slot'])[0]) <=> intval(explode(':', $b['slot'])[0]);
    });

    return response()->json([
        'closed' => false,
        'hours' => $result
    ]);
}

/*public function store(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;
    $today = Carbon::today();

    // ================= VALIDATION =================
    $request->validate([
        'terrain_id' => 'required|exists:terrains,id',
        'type' => 'required|in:simple,multi,fixe',
        'payment_method' => 'nullable|in:cash,card',
        'client_name' => 'nullable|string|max:255',
        'client_phone' => 'nullable|string|max:20',
        'payment_method' => 'nullable|in:cash,card,online,stripe,paypal',
    ]);

    // ================= CLIENT LOGIC =================
    $isStaff = $user->role === 'staff';

    $clientName = $isStaff
        ? $request->client_name
        : ($request->client_name ?? $user->name);

    $clientPhone = $isStaff
        ? $request->client_phone
        : ($request->client_phone ?? $user->phone);

    // ==================================================
    // SIMPLE
    // ==================================================
    if ($request->type === 'simple') {

        $request->validate([
            'reservation_date' => 'required|date',
            'slot' => 'required|string',
        ]);

        if (!str_contains($request->slot, '-')) {
            return back()->withErrors(['slot' => '❌ Slot invalide']);
        }

        [$start_time, $end_time] = array_map('trim', explode('-', $request->slot));

        $exists = Reservation::where('terrain_id', $request->terrain_id)
            ->where('reservation_date', $request->reservation_date)
            ->where('start_time', $start_time)
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => '❌ Déjà réservé']);
        }

        $reservation = Reservation::create([
            'user_id' => $userId,
            'terrain_id' => $request->terrain_id,
            'reservation_date' => $request->reservation_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'type' => 'simple',
            'status' => 'confirmed',
            'payment_status' => $request->payment_method === 'cash' ? 'unpaid' : 'pending',
            'client_name' => $clientName,
            'client_phone' => $clientPhone,
                'payment_method' => $request->payment_method ?? 'cash',

            
        ]);


        return redirect()->route('reservations.index')
            ->with('success', '✅ Réservation simple créée');
    }

    // ==================================================
    // MULTI
    // ==================================================
    if ($request->type === 'multi') {

        $request->validate([
            'selected_dates' => 'required',
        ]);

        $dates = json_decode($request->selected_dates, true);

        if (!is_array($dates) || empty($dates)) {
            return back()->withErrors(['error' => '❌ Aucune sélection']);
        }

        foreach ($dates as $item) {

            if (!isset($item['date'], $item['slot'])) continue;
            if (!str_contains($item['slot'], '-')) continue;

            [$start_time, $end_time] = array_map('trim', explode('-', $item['slot']));

            $exists = Reservation::where('terrain_id', $request->terrain_id)
                ->where('reservation_date', $item['date'])
                ->where('start_time', $start_time)
                ->exists();

            if (!$exists) {

                $reservation = Reservation::create([
                    'user_id' => $userId,
                    'terrain_id' => $request->terrain_id,
                    'reservation_date' => $item['date'],
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'type' => 'multi',
                    'status' => 'confirmed',
                    'payment_status' => $request->payment_method === 'cash' ? 'unpaid' : 'pending',
                    'client_name' => $clientName,
                    'client_phone' => $clientPhone,
                        'payment_method' => $request->payment_method ?? 'cash',

                ]);

            }
        }

        return redirect()->route('reservations.index')
            ->with('success', '✅ Réservations multi créées');
    }

    // ==================================================
    // FIXE
    // ==================================================
    if ($request->type === 'fixe') {

        $request->validate([
            'selected_dates' => 'required',
            'months_duration' => 'required|integer|min:1|max:12',
        ]);

        $months = (int) $request->months_duration;
        $dates = json_decode($request->selected_dates, true);

        if (!is_array($dates) || empty($dates)) {
            return back()->withErrors(['error' => '❌ Aucune sélection']);
        }

        $groupId = Str::uuid();
        $created = 0;

        foreach ($dates as $item) {

            if (!isset($item['date'], $item['slot'])) continue;
            if (!str_contains($item['slot'], '-')) continue;

            [$start_time, $end_time] = array_map('trim', explode('-', $item['slot']));

            $startDate = Carbon::parse($item['date']);
            $dayOfWeek = $startDate->dayOfWeek;
            $endDate = $startDate->copy()->addMonths($months);

            $current = $startDate->copy();

            while ($current <= $endDate) {

                if ($current->dayOfWeek === $dayOfWeek) {

                    if ($current->lt($today)) {
                        $current->addDay();
                        continue;
                    }

                    $exists = Reservation::where('terrain_id', $request->terrain_id)
                        ->where('reservation_date', $current->format('Y-m-d'))
                        ->where('start_time', $start_time)
                        ->exists();

                    if (!$exists) {

                        $reservation = Reservation::create([
                            'user_id' => $userId,
                            'terrain_id' => $request->terrain_id,
                            'reservation_date' => $current->format('Y-m-d'),
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'type' => 'fixe',
                            'status' => 'confirmed',
                            'payment_status' => $request->payment_method === 'cash' ? 'unpaid' : 'pending',
                            'group_id' => $groupId,
                            'client_name' => $clientName,
                            'client_phone' => $clientPhone,
                                'payment_method' => $request->payment_method ?? 'cash',
                        ]);


                        $created++;
                    }
                }

                $current->addDay();
            }
        }

        return redirect()->route('reservations.index')
            ->with('success', "✅ FIXE créée ($created réservations)");
    }

    return back()->withErrors(['error' => '❌ Type invalide']);
}*/
public function store(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;
    $today = Carbon::today();

    // ================= VALIDATION =================
    $request->validate([
        'terrain_id' => 'required|exists:terrains,id',
        'type' => 'required|in:simple,multi,fixe',

        'payment_method' => 'required|in:cash,card,online,stripe,paypal',

        'client_name' => 'nullable|string|max:255',
        'client_phone' => 'nullable|string|max:20',
    ]);

    // ================= CLIENT =================
    $isStaff = $user->role === 'staff';

    $clientName = $isStaff
        ? $request->client_name
        : ($request->client_name ?? $user->name);

    $clientPhone = $isStaff
        ? $request->client_phone
        : ($request->client_phone ?? $user->phone);

    // ==================================================
    // SIMPLE
    // ==================================================
    if ($request->type === 'simple') {

        $request->validate([
            'reservation_date' => 'required|date',
            'slot' => 'required|string',
        ]);

        if (!str_contains($request->slot, '-')) {
            return back()->withErrors([
                'slot' => '❌ Slot invalide'
            ]);
        }

        [$start_time, $end_time] = array_map(
            'trim',
            explode('-', $request->slot)
        );

        // CHECK EXISTS
        $exists = Reservation::where('terrain_id', $request->terrain_id)
            ->where('reservation_date', $request->reservation_date)
            ->where('start_time', $start_time)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'error' => '❌ Déjà réservé'
            ]);
        }

        // CREATE RESERVATION
        $reservation = Reservation::create([
            'user_id' => $userId,
            'terrain_id' => $request->terrain_id,

            'reservation_date' => $request->reservation_date,

            'start_time' => $start_time,
            'end_time' => $end_time,

            'type' => 'simple',

            'status' => 'confirmed',

            'payment_status' => $request->payment_method === 'cash'
                ? 'unpaid'
                : 'pending',

            'payment_method' => $request->payment_method,

            'client_name' => $clientName,
            'client_phone' => $clientPhone,
        ]);

        // ================= ONLINE PAYMENT =================
        if (in_array($request->payment_method, [
            'card',
            'online',
            'stripe',
            'paypal'
        ])) {

            return redirect()->route(
                'payment.checkout',
                $reservation->id
            );
        }

        return redirect()
            ->route('reservations.index')
            ->with('success', '✅ Réservation simple créée');
    }

    // ==================================================
    // MULTI
    // ==================================================
    if ($request->type === 'multi') {

        $request->validate([
            'selected_dates' => 'required',
        ]);

        $dates = json_decode($request->selected_dates, true);

        if (!is_array($dates) || empty($dates)) {
            return back()->withErrors([
                'error' => '❌ Aucune sélection'
            ]);
        }

        $firstReservation = null;

        foreach ($dates as $item) {

            if (!isset($item['date'], $item['slot'])) {
                continue;
            }

            if (!str_contains($item['slot'], '-')) {
                continue;
            }

            [$start_time, $end_time] = array_map(
                'trim',
                explode('-', $item['slot'])
            );

            $exists = Reservation::where('terrain_id', $request->terrain_id)
                ->where('reservation_date', $item['date'])
                ->where('start_time', $start_time)
                ->exists();

            if (!$exists) {

                $reservation = Reservation::create([
                    'user_id' => $userId,
                    'terrain_id' => $request->terrain_id,

                    'reservation_date' => $item['date'],

                    'start_time' => $start_time,
                    'end_time' => $end_time,

                    'type' => 'multi',

                    'status' => 'confirmed',

                    'payment_status' => $request->payment_method === 'cash'
                        ? 'unpaid'
                        : 'pending',

                    'payment_method' => $request->payment_method,

                    'client_name' => $clientName,
                    'client_phone' => $clientPhone,
                ]);

                if (!$firstReservation) {
                    $firstReservation = $reservation;
                }
            }
        }

        // ================= ONLINE PAYMENT =================
        if (
            $firstReservation &&
            in_array($request->payment_method, [
                'card',
                'online',
                'stripe',
                'paypal'
            ])
        ) {

            return redirect()->route(
                'payment.checkout',
                $firstReservation->id
            );
        }

        return redirect()
            ->route('reservations.index')
            ->with('success', '✅ Réservations multi créées');
    }

    // ==================================================
    // FIXE
    // ==================================================
    if ($request->type === 'fixe') {

        $request->validate([
            'selected_dates' => 'required',

            'months_duration' =>
                'required|integer|min:1|max:12',
        ]);

        $months = (int) $request->months_duration;

        $dates = json_decode($request->selected_dates, true);

        if (!is_array($dates) || empty($dates)) {
            return back()->withErrors([
                'error' => '❌ Aucune sélection'
            ]);
        }

        $groupId = Str::uuid();

        $created = 0;

        $firstReservation = null;

        foreach ($dates as $item) {

            if (!isset($item['date'], $item['slot'])) {
                continue;
            }

            if (!str_contains($item['slot'], '-')) {
                continue;
            }

            [$start_time, $end_time] = array_map(
                'trim',
                explode('-', $item['slot'])
            );

            $startDate = Carbon::parse($item['date']);

            $dayOfWeek = $startDate->dayOfWeek;

            $endDate = $startDate
                ->copy()
                ->addMonths($months);

            $current = $startDate->copy();

            while ($current <= $endDate) {

                if ($current->dayOfWeek === $dayOfWeek) {

                    if ($current->lt($today)) {
                        $current->addDay();
                        continue;
                    }

                    $exists = Reservation::where(
                            'terrain_id',
                            $request->terrain_id
                        )
                        ->where(
                            'reservation_date',
                            $current->format('Y-m-d')
                        )
                        ->where('start_time', $start_time)
                        ->exists();

                    if (!$exists) {

                        $reservation = Reservation::create([
                            'user_id' => $userId,
                            'terrain_id' => $request->terrain_id,

                            'reservation_date' =>
                                $current->format('Y-m-d'),

                            'start_time' => $start_time,
                            'end_time' => $end_time,

                            'type' => 'fixe',

                            'status' => 'confirmed',

                            'payment_status' =>
                                $request->payment_method === 'cash'
                                    ? 'unpaid'
                                    : 'pending',

                            'payment_method' =>
                                $request->payment_method,

                            'group_id' => $groupId,

                            'client_name' => $clientName,
                            'client_phone' => $clientPhone,
                        ]);

                        if (!$firstReservation) {
                            $firstReservation = $reservation;
                        }

                        $created++;
                    }
                }

                $current->addDay();
            }
        }

        // ================= ONLINE PAYMENT =================
        if (
            $firstReservation &&
            in_array($request->payment_method, [
                'card',
                'online',
                'stripe',
                'paypal'
            ])
        ) {

            return redirect()->route(
                'payment.checkout',
                $firstReservation->id
            );
        }

        return redirect()
            ->route('reservations.index')
            ->with(
                'success',
                "✅ FIXE créée ($created réservations)"
            );
    }

    return back()->withErrors([
        'error' => '❌ Type invalide'
    ]);
}

public function verifyPayment($token)
{
    $reservation = Reservation::where('qr_token', $token)->first();

    if (!$reservation) {
        abort(404, 'QR invalide');
    }

    if ($reservation->payment_status === 'paid') {
        return redirect()->route('payment.paid', $token);
    }

    return redirect()->route('payment.unpaid', $token);
}
   public function paidView($token)
{
    $reservation = Reservation::where('qr_token', $token)->firstOrFail();

    return view('reservations.paid', compact('reservation'));
}

public function unpaidView($token)
{
    $reservation = Reservation::where('qr_token', $token)->firstOrFail();

    return view('reservations.unpaid', compact('reservation'));
}
public function cancel($id)
{
    $res = Reservation::findOrFail($id);

    $reservationDateTime = Carbon::parse($res->reservation_date . ' ' . $res->start_time);

    // ❌ interdit moins de 2h
    if (now()->diffInHours($reservationDateTime, false) < 2) {
        return back()->withErrors([
            'error' => '❌ Impossible d’annuler (moins de 2 heures restantes)'
        ]);
    }

    $res->status = 'cancelled';
    $res->save();

    return back()->with('success', '✅ Réservation annulée');
}
public function destroy($id)
{
    $res = Reservation::findOrFail($id);

    $reservationDateTime = Carbon::parse($res->reservation_date . ' ' . $res->start_time);

    // ❌ أقل من 2h ممنوع
    if (now()->diffInHours($reservationDateTime, false) < 2) {
        return back()->withErrors([
            'error' => '❌ Impossible d’annuler (moins de 2h)'
        ]);
    }

    // 🗑️ حذف الحجز
    $res->delete();

    return back()->with('success', '✅ Réservation annulée');
}
   
}