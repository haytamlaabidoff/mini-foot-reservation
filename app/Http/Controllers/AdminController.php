<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash; 
use App\Models\Terrain;
use App\Models\Reservation;
use Carbon\Carbon;
class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('user')->latest()->get();
        return view('admin.index', compact('admins'));
    }



public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',

        'phone' => 'nullable|string',
        'cin' => 'required|string|unique:admins,cin',

        'address' => 'nullable|string',

        'password' => 'required|min:6',
    ]);

    // 🔥 PASSWORD = CIN (option)
    $plainPassword = $request->password;

    // 👤 USER (login)
    $user = User::create([
        'name' => $request->name,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($plainPassword),
        'role' => 'admin',
    ]);

    // 🧾 ADMIN PROFILE
    Admin::create([
        'user_id' => $user->id,
            'cin' => $request->cin,

        'phone' => $request->phone,
        'address' => $request->address,
        'notes' => null,

    ]);

    return redirect()->route('admin.index')
        ->with('success', 'Admin créé avec succès');
}
    public function create()
    {
                $users = User::where('role', '!=', 'admin')->get(); // تجنب التكرار

        return view('admin.create', compact('users'));
    }

  

    public function edit($id)
    {
        $admin = Admin::with('user')->findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $admin = Admin::findOrFail($id);

        $admin->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Admin modifié');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        // 👇 rollback role
        $user = $admin->user;
        $user->role = 'user';
        $user->save();

        $admin->delete();

        return back()->with('success', 'Admin supprimé');
    }

public function dashboard()
{
      $calendarReservations = \App\Models\Reservation::with('terrain')
        ->get()
        ->map(function ($res) {
            return [
                'title' => $res->client_name . ' - ' . $res->terrain->name,
                'start' => $res->reservation_date . 'T' . $res->start_time,
                'end'   => $res->reservation_date . 'T' . $res->end_time,
                'color' => $res->status === 'confirmed' ? 'green' : 'red',
            ];
        });
    return view('admin.dashboard', [

        'users' => \App\Models\User::count(),
        'terrains' => \App\Models\Terrain::count(),

        'reservationsToday' => \App\Models\Reservation::whereDate('reservation_date', today())->count(),

        'confirmedReservations' => \App\Models\Reservation::where('status', 'confirmed')->count(),

        'cancelledReservations' => \App\Models\Reservation::where('status', 'cancelled')->count(),

        'pendingPayments' => \App\Models\Reservation::where('payment_status', 'pending')->count(),
'revenueToday' => \App\Models\Reservation::with('terrain')
    ->whereDate('reservation_date', today())
    ->where('payment_status', 'paid')
    ->get()
    ->sum(function ($res) {
        $hours = \Carbon\Carbon::parse($res->start_time)
            ->diffInHours(\Carbon\Carbon::parse($res->end_time));

        return $hours * ($res->terrain->price_per_hour ?? 0);
    }),
            'calendarReservations' => $calendarReservations,


      'latestReservations' => \App\Models\Reservation::with('terrain')
    ->whereDate('reservation_date', '>=', today())
    ->orderBy('reservation_date', 'asc')
    ->take(10)
    ->get(),
    ]);
    
}
public function togglePayment($id)
{
    $reservation = \App\Models\Reservation::findOrFail($id);

    // تبديل الحالة
    $reservation->payment_status =
        $reservation->payment_status === 'paid'
            ? 'pending'
            : 'paid';

    $reservation->save();

    return back()->with('success', 'Payment status updated successfully');
}

}