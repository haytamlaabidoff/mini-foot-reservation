<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationPdfController extends Controller
{
    /*public function show($id)
    {
        $reservation = Reservation::with('terrain')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$reservation) {
            abort(404, 'Réservation introuvable');
        }

 
        // 📄 PDF
        $pdf = Pdf::loadView('pdf.reservation', [
            'reservation' => $reservation,
        ]);

        return $pdf->download('reservation-' . $reservation->id . '.pdf');
    }   */
public function show($id)
{
    $reservation = Reservation::with('terrain')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

$qr = base64_encode(
    QrCode::format('svg')
        ->size(200)
        ->errorCorrection('H')
        ->generate(url('/scan/' . $reservation->qr_token))
);

$data = [
    'title' => 'Welcome to Online Web Tutor',
    'qrcode' => $qr
]; 
        $pdf = PDF::loadView('my-pdf', $data);
  

    $pdf = Pdf::loadView('pdf.reservation', [
        'reservation' => $reservation,
        'qr' => $qr,
    ]);

    return $pdf->download('reservation-' . $reservation->id . '.pdf');
}
}