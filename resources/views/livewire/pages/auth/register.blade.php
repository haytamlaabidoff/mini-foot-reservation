<?php

use App\Models\User;
use App\Models\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public string $phone = '';
    public string $cin = '';
    public string $address = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],

            'phone' => ['nullable', 'string', 'max:20'],
            'cin' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        // CREATE USER
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        // CREATE CLIENT
        Client::create([
            'user_id' => $user->id,
            'phone' => $validated['phone'],
            'cin' => $validated['cin'],
            'address' => $validated['address'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
};

?>

<div class="max-w-md mx-auto">

    <form wire:submit="register">

        <!-- NAME -->
        <div>
            <x-input-label value="Name" />
            <x-text-input wire:model="name" class="block mt-1 w-full" type="text" />
        </div>

        <!-- EMAIL -->
        <div class="mt-4">
            <x-input-label value="Email" />
            <x-text-input wire:model="email" class="block mt-1 w-full" type="email" />
        </div>

        <!-- PASSWORD -->
        <div class="mt-4">
            <x-input-label value="Password" />
            <x-text-input wire:model="password" class="block mt-1 w-full" type="password" />
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="mt-4">
            <x-input-label value="Confirm Password" />
            <x-text-input wire:model="password_confirmation" class="block mt-1 w-full" type="password" />
        </div>

        <hr class="my-6">

        <h3 class="font-bold">Client Info</h3>

        <!-- PHONE -->
        <div class="mt-4">
            <x-input-label value="Phone" />
            <x-text-input wire:model="phone" class="block mt-1 w-full" type="text" />
        </div>

        <!-- CIN -->
        <div class="mt-4">
            <x-input-label value="CIN" />
            <x-text-input wire:model="cin" class="block mt-1 w-full" type="text" />
        </div>

        <!-- ADDRESS -->
        <div class="mt-4">
            <x-input-label value="Address" />
            <x-text-input wire:model="address" class="block mt-1 w-full" type="text" />
        </div>

        <!-- BUTTON -->
        <div class="mt-6">
            <x-primary-button class="w-full">
                Register
            </x-primary-button>
        </div>

    </form>

</div>