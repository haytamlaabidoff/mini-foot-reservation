<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    // =========================
    // STORE RESERVATION
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'terrain_id' => 'required|exists:terrains,id',
            'reservation_date' => 'required|date',
            'slot' => 'required',
            'type' => 'required|in:simple,fixe',
            'payment_method' => 'nullable|in:cash,card',
            'client_name' => 'nullable|string',
            'client_phone' => 'nullable|string',

            'selected_months' => 'nullable|array',
            'selected_dates' => 'nullable|array',
        ]);

        [$start_time, $end_time] = array_map('trim', explode('-', $request->slot));

        $userId = Auth::id();
        $groupId = Str::uuid();

        $created = 0;

        // ==================================================
        // SIMPLE RESERVATION
        // ==================================================
        if ($request->type === 'simple') {

            $exists = Reservation::where('terrain_id', $request->terrain_id)
                ->where('reservation_date', $request->reservation_date)
                ->whereTime('start_time', $start_time)
                ->exists();

            if ($exists) {
                return back()->withErrors(['error' => '❌ Slot déjà réservé']);
            }

            Reservation::create([
                'user_id' => $userId,
                'terrain_id' => $request->terrain_id,
                'reservation_date' => $request->reservation_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'type' => 'simple',
                'status' => 'confirmed',
                'payment_status' => $request->payment_method === 'cash' ? 'unpaid' : 'pending',
                'qr_token' => Str::uuid(),
            ]);

            return redirect()->route('reservations.index')
                ->with('success', '🎉 Réservation simple créée');
        }

        // ==================================================
        // FIXE RESERVATION (MONTHS + DATES)
        // ==================================================
        if ($request->type === 'fixe') {

            $months = $request->selected_months ?? [];
            $dates  = $request->selected_dates ?? [];

            if (empty($months) && empty($dates)) {
                return back()->withErrors(['error' => '❌ Choisissez mois ou dates']);
            }

            $year = Carbon::parse($request->reservation_date)->year;

            // =========================
            // MONTHS LOOP
            // =========================
            foreach ($months as $month) {

                $start = Carbon::create($year, $month, 1);
                $end = (clone $start)->endOfMonth();

                while ($start <= $end) {

                    $this->createReservationIfNotExists(
                        $request,
                        $start,
                        $groupId,
                        $created,
                        $start_time,
                        $end_time
                    );

                    $start->addDay();
                }
            }

            // =========================
            // CUSTOM DATES LOOP
            // =========================
            foreach ($dates as $date) {

                $day = Carbon::parse($date);

                $this->createReservationIfNotExists(
                    $request,
                    $day,
                    $groupId,
                    $created,
                    $start_time,
                    $end_time
                );
            }

            return redirect()->route('reservations.index')
                ->with('success', "🎉 Réservations FIXE créées ($created)");
        }

        return back()->withErrors(['error' => '❌ Type invalide']);
    }

    // ==================================================
    // HELPER FUNCTION
    // ==================================================
    private function createReservationIfNotExists($request, $date, $groupId, &$created, $start_time, $end_time)
    {
        $exists = Reservation::where('terrain_id', $request->terrain_id)
            ->where('reservation_date', $date->format('Y-m-d'))
            ->whereTime('start_time', $start_time)
            ->exists();

        if (!$exists) {

            Reservation::create([
                'user_id' => Auth::id(),
                'terrain_id' => $request->terrain_id,

                'reservation_date' => $date->format('Y-m-d'),
                'start_time' => $start_time,
                'end_time' => $end_time,

                'type' => 'fixe',
                'status' => 'confirmed',

                'group_id' => $groupId,

                'selected_months' => $request->selected_months,
                'selected_dates' => $request->selected_dates,
                'year' => now()->year,

                'qr_token' => Str::uuid(),
            ]);

            $created++;
        }
    }
}