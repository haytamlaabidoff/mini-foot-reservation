<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terrain;
use App\Models\GeneralSetting;
use App\Models\WorkingHour;
use App\Models\Sport;
use App\Models\SportFormat;
use App\Models\Reservation;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * ===============================
     * GET HOURS AJAX
     * ===============================
     */
    public function getHours(Request $request, $id)
    {
        $date = $request->date;

        if (!$date) {
            return response()->json([
                'closed' => true,
                'hours' => []
            ]);
        }

        $dayName = Carbon::parse($date)->format('l');

        // ================= WORKING HOURS =================
        $workingHours = WorkingHour::whereJsonContains('days', $dayName)->get();

        if ($workingHours->isEmpty()) {
            return response()->json([
                'closed' => true,
                'hours' => []
            ]);
        }

        // ================= AVAILABLE HOURS =================
        $availableHours = [];

        foreach ($workingHours as $wh) {

            $start = (int) Carbon::parse($wh->open_time)->format('H');
            $end   = (int) Carbon::parse($wh->close_time)->format('H');

            // normal
            if ($start < $end) {

                for ($h = $start; $h < $end; $h++) {
                    $availableHours[] = $h;
                }

            }
            // overnight
            else {

                for ($h = $start; $h < 24; $h++) {
                    $availableHours[] = $h;
                }

                for ($h = 0; $h < $end; $h++) {
                    $availableHours[] = $h;
                }
            }
        }

        $availableHours = array_unique($availableHours);

        // ================= CHECK ALL TERRAINS =================
        $terrainIds = Terrain::query()
            ->where('status', 1)
            ->pluck('id');

        // ================= RESULT =================
        $result = [];

        foreach ($availableHours as $h) {

            $next = ($h + 1) % 24;

            $startTime = sprintf('%02d:00:00', $h);
            $endTime   = sprintf('%02d:00:00', $next);

            // ================= CHECK RESERVATIONS =================
            $reservedCount = Reservation::whereIn('terrain_id', $terrainIds)
                ->where('reservation_date', $date)
                ->where('status', '!=', 'cancelled')

                ->where(function ($q) use ($startTime, $endTime) {

                    $q->whereBetween('start_time', [$startTime, $endTime])

                        ->orWhereBetween('end_time', [$startTime, $endTime])

                        ->orWhere(function ($x) use ($startTime, $endTime) {

                            $x->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);

                        });

                })

                ->count();

            // ================= AVAILABLE ? =================
            $allTerrainsReserved = $reservedCount >= $terrainIds->count();

            // ================= BLOCK PAST + 5 MIN =================
            $slotStart = Carbon::parse($date . ' ' . $startTime);

            $isPast = now()->greaterThanOrEqualTo(
                $slotStart->copy()->subMinutes(5)
            );

            $result[] = [
                'slot' => sprintf('%02d:00 - %02d:00', $h, $next),

                'status' => ($allTerrainsReserved || $isPast)
                    ? 'reserved'
                    : 'available'
            ];
        }

        // ================= SORT =================
      usort($result, function ($a, $b) {

    return intval(explode(':', $a['slot'])[0])
        <=>
        intval(explode(':', $b['slot'])[0]);

});

        return response()->json([
            'closed' => false,
            'hours' => $result
        ]);
    }

    /**
     * ===============================
     * HOME
     * ===============================
     */
    public function index(Request $request)
    {
        $sport  = $request->sport;
        $format = $request->format;
        $date   = $request->date;
        $slot   = $request->slot;

        $setting = GeneralSetting::first();

        $sports = Sport::all();

        // ================= FORMATS =================
        $sportFormats = collect();

        if ($sport) {

            $sportFormats = SportFormat::where('sport_id', $sport)
                ->where('status', 1)
                ->get();
        }

        // ================= FIRST TERRAIN =================
        $firstTerrain = Terrain::query()

            ->when($sport, function ($q) use ($sport) {
                $q->where('sport_id', $sport);
            })

            ->when($format, function ($q) use ($format) {
                $q->where('sport_format_id', $format);
            })

            ->first();

        // ================= WORKING HOURS =================
        $workingHours = WorkingHour::all();

        $now = Carbon::now();

        $currentTime = $now->format('H:i:s');
        $currentDay  = $now->format('l');

        $isOpen = false;

        foreach ($workingHours as $wh) {

            $days = is_array($wh->days)
                ? $wh->days
                : json_decode($wh->days, true);

            $days = $days ?? [];

            if (in_array($currentDay, $days) && !$wh->is_closed) {

                $open  = $wh->open_time;
                $close = $wh->close_time;

                // normal
                if ($open < $close) {

                    if ($currentTime >= $open && $currentTime <= $close) {
                        $isOpen = true;
                    }

                }
                // overnight
                else {

                    if ($currentTime >= $open || $currentTime <= $close) {
                        $isOpen = true;
                    }
                }
            }
        }

        // ================= TERRAINS =================
        $terrains = Terrain::with([
                'sport',
                'sportFormat',
                'reservations'
            ])

            ->where('status', 1)

            ->when($sport, function ($q) use ($sport) {
                $q->where('sport_id', $sport);
            })

            ->when($format, function ($q) use ($format) {
                $q->where('sport_format_id', $format);
            })

            // ================= FILTER AVAILABLE =================
            ->when($date && $slot, function ($q) use ($date, $slot) {

                [$startTime, $endTime] = explode(' - ', $slot);

                $startTime .= ':00';
                $endTime   .= ':00';

                $q->whereDoesntHave('reservations', function ($r) use ($date, $startTime, $endTime) {

                    $r->where('reservation_date', $date)

                        ->where('status', '!=', 'cancelled')

                        ->where(function ($sub) use ($startTime, $endTime) {

                            $sub->whereBetween('start_time', [$startTime, $endTime])

                                ->orWhereBetween('end_time', [$startTime, $endTime])

                                ->orWhere(function ($x) use ($startTime, $endTime) {

                                    $x->where('start_time', '<=', $startTime)
                                        ->where('end_time', '>=', $endTime);

                                });

                        });

                });

            })

            ->get()

            ->groupBy(function ($terrain) {

                return optional($terrain->sportFormat)->name
                    ?? 'Sans format';
            });

        return view('welcome', compact(
            'terrains',
            'setting',
            'workingHours',
            'isOpen',
            'sports',
            'sportFormats',
            'date',
            'slot',
            'sport',
            'format',
            'firstTerrain'
        ));
    }
}