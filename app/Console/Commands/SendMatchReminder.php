<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SendMatchReminder extends Command
{
    protected $signature = 'app:send-match-reminder';

    protected $description = 'Send WhatsApp reminder 1 hour before match';

public function handle()
{
    $now = Carbon::now();

    $reservations = Reservation::with('terrain')
        ->whereDate('reservation_date', $now->toDateString())
        ->where('sent_reminder', false)
        ->where('status', 'confirmed')
        ->get();

    foreach ($reservations as $res) {

        $matchTime = Carbon::parse($res->reservation_date . ' ' . $res->start_time);

        $diff = $matchTime->diffInMinutes($now, false);

        // ⏰ 1 hour reminder window
        if ($diff <= 60 && $diff >= 50) {

            $this->sendWhatsApp($res);

            $res->update([
                'sent_reminder' => true
            ]);
        }
    }
}
    private function sendWhatsApp($reservation)
    {
        $clientPhone = $reservation->client_phone;

        $message = "⚽ Rappel Match\n"
            . "Bonjour " . $reservation->client_name . "\n"
            . "Votre match est prévu dans 1 heure 🕒\n"
            . "Terrain: " . $reservation->terrain->name . "\n"
            . "Heure: " . $reservation->slot;

        Http::withBasicAuth(env('TWILIO_SID'), env('TWILIO_TOKEN'))
            ->post("https://api.twilio.com/whatsapp/send", [
                "from" => "whatsapp:+212667417622",
                "to" => "whatsapp:$clientPhone",
                "body" => $message
            ]);
    }
}