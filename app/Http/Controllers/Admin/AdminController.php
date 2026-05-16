<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Terrain;

class AdminController extends Controller
{
   
    // Dashboard admin
   public function index()
{
    $users = User::count();
    $reservations = Reservation::count();
    $terrains = Terrain::count();

    $latestReservations = Reservation::latest()->take(5)->get();

    // 📅 Calendar events
    $calendarReservations = Reservation::with('terrain')
        ->get()
        ->map(function ($res) {
            return [
                'id' => $res->id,
                'title' => 'Terrain: ' . ($res->terrain->name ?? 'N/A'),
                'start' => $res->reservation_date . 'T' . $res->start_time,
                'end' => $res->reservation_date . 'T' . $res->end_time,
                'color' => $res->payment_status == 'paid' ? 'green' : 'red',
            ];
        });

    return view('admin.dashboard', compact(
        'users',
        'reservations',
        'terrains',
        'latestReservations',
        'calendarReservations'
    ));
}


    // Liste des utilisateurs
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Liste des réservations
    public function reservations()
    {
        $reservations = Reservation::with('user','terrain')
            ->latest()
            ->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }

    // Supprimer un user
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Utilisateur supprimé');
    }

    // Supprimer réservation
    public function deleteReservation($id)
    {
        Reservation::findOrFail($id)->delete();
        return back()->with('success', 'Réservation supprimée');
    }
public function dashboard()
{
    // 👥 Total Users
    $totalUsers = User::count();

    // ⚽ Total Terrains
    $totalTerrains = Terrain::count();

    // 📅 Reservations Today
    $reservationsToday = Reservation::whereDate(
        'reservation_date',
        today()
    )->count();

    // ✅ Confirmed Reservations
    $confirmedReservations = Reservation::where(
        'status',
        'confirmed'
    )->count();

    // ❌ Cancelled Reservations
    $cancelledReservations = Reservation::where(
        'status',
        'cancelled'
    )->count();

    // ⏳ Pending Payments
    $pendingPayments = Reservation::where(
        'payment_status',
        'pending'
    )->count();

    // 💰 Revenue Today
    // إذا عندك column price استعمل sum('price')
    // إذا ماعندكش خليه count * prix
    $revenueToday = Reservation::whereDate(
            'reservation_date',
            today()
        )
        ->where('payment_status', 'paid')
        ->count() * 100;

    // 📋 Latest Reservations
    $latestReservations = Reservation::with([
            'terrain',
            'user'
        ])
        ->latest()
        ->take(10)
        ->get();

    // 📊 Monthly Reservations
    $monthlyReservations = Reservation::selectRaw(
            'MONTH(reservation_date) as month, COUNT(*) as total'
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // 📊 Total Paid Reservations
    $paidReservations = Reservation::where(
        'payment_status',
        'paid'
    )->count();

    // 📊 Active Reservations
    $activeReservations = Reservation::where(
        'status',
        'confirmed'
    )->whereDate(
        'reservation_date',
        '>=',
        today()
    )->count();

    return view('admin.dashboard', compact(
        'totalUsers',
        'totalTerrains',
        'reservationsToday',
        'confirmedReservations',
        'cancelledReservations',
        'pendingPayments',
        'revenueToday',
        'latestReservations',
        'monthlyReservations',
        'paidReservations',
        'activeReservations'
    ));
}
}