<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('user')->get();
        return view('client.index', compact('clients'));
    }

    public function create()
    {
        $users = User::all();
        return view('client.create', compact('users'));
    }

    public function store(Request $request)
    {
        Client::create([
            'user_id' => $request->user_id,
            'phone' => $request->phone,
            'cin' => $request->cin,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Client ajouté');
    }
}