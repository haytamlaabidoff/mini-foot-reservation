<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;
use Mail;
use App\Mail\ReservationReminderMail;

class SendReservationReminders extends Command
{
    protected $signature = 'reservations:send-reminders';
    protected $description = 'Send reservation emails on the same day';

  public function handle()
{
    $now = Carbon::now();

    $reservations = Reservation::where('status', 'confirmed')
        ->whereDate('reservation_date', '>=', $now->toDateString())
        ->get();

    foreach ($reservations as $res) {

        if (!$res->user || !$res->user->email) {
            continue;
        }

        $start = Carbon::parse($res->reservation_date . ' ' . $res->start_time);

        $diff = $now->diffInMinutes($start, false);

        // ⏰ باقي بين 110min و 120min (حوالي 2h)
        if ($diff <= 120 && $diff >= 110) {

            Mail::to($res->user->email)
                ->send(new ReservationReminderMail($res));
        }
    }

    $this->info('Reminder emails checked successfully!');
}
}