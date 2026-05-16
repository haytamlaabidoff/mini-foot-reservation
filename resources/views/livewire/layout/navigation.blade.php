<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
};
?>

@php
$links = [
    ['route' => 'dashboard', 'label' => '🏠 Dashboard'],
    ['route' => 'working-hours.index', 'label' => '⏰ Working Hours'],
    ['route' => 'staff.index', 'label' => '👨‍💼 Staff'],
    ['route' => 'departments.index', 'label' => '📁 Departments'],
    ['route' => 'posts.index', 'label' => '📝 Posts'],
    ['route' => 'terrains.index', 'label' => '⚽ Terrains'],

    // ✅ AJOUTER
    ['route' => 'sports.index', 'label' => '🏆 Sports'],
    ['route' => 'sport-formats.index', 'label' => '📋 Sport Formats'],
        ['route' => 'scanner.index', 'label' => '📋scanner'],

];
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <!-- TOP BAR -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex items-center gap-4">

                <a href="{{ route('dashboard') }}" wire:navigate>
                    <x-application-logo class="h-9 w-auto text-gray-800" />
                </a>

                <!-- DESKTOP MENU -->
                <div class="hidden sm:flex gap-3">
                    @foreach($links as $link)
                        <x-nav-link 
                            :href="route($link['route'])"
                            :active="request()->routeIs($link['route'].'*')"
                            wire:navigate>
                            {{ $link['label'] }}
                        </x-nav-link>
                    @endforeach
                </div>

            </div>

            <!-- RIGHT -->
            <div class="hidden sm:flex items-center">

                @auth
                <x-dropdown align="right">
                    <x-slot name="trigger">

                        <button class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">

                            <span>{{ auth()->user()->name }}</span>

                            <svg class="w-4 h-4" viewBox="0 0 20 20">
                                <path fill="currentColor"
                                      d="M5.23 7.21a1 1 0 011.41 0L10 10.58l3.36-3.37a1 1 0 111.41 1.42l-4.07 4.07a1 1 0 01-1.41 0L5.23 8.63a1 1 0 010-1.42z"/>
                            </svg>

                        </button>

                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            Profile
                        </x-dropdown-link>

                        <button wire:click="logout" class="w-full text-left">
                            <x-dropdown-link>
                                Logout
                            </x-dropdown-link>
                        </button>

                    </x-slot>
                </x-dropdown>
                @endauth

            </div>

            <!-- MOBILE BUTTON -->
            <div class="sm:hidden flex items-center">
                <button @click="open = true" class="text-gray-600 text-xl">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- OVERLAY -->
    <div x-show="open"
         x-transition.opacity
         class="fixed inset-0 bg-black bg-opacity-50 z-40"
         @click="open = false">
    </div>

    <!-- MOBILE SIDEBAR -->
    <div x-show="open"
         x-transition:enter="transition transform duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed top-0 left-0 h-full w-64 bg-gradient-to-b from-yellow-400 to-black-900 text-white z-50 p-5"
         class="fixed top-0 left-0 h-full w-64 bg-black text-yellow-400 z-50 p-5">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-bold text-lg">Menu</h2>
            <button @click="open = false">✖</button>
        </div>

        <!-- LINKS -->
        <div class="flex flex-col gap-3">
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="block px-4 py-2 rounded hover:bg-blue-600 transition">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <!-- USER -->
        <div class="mt-10 border-t border-blue-400 pt-4">

            @auth
                <div class="font-bold">{{ auth()->user()->name }}</div>
                <div class="text-sm text-blue-200 mb-3">
                    {{ auth()->user()->email }}
                </div>

                <button wire:click="logout"
                        class="bg-red-500 hover:bg-red-600 w-full py-2 rounded">
                    Logout
                </button>
            @endauth

            @guest
                <a href="/login"
                   class="block text-center bg-white text-blue-700 py-2 rounded">
                    Login
                </a>
            @endguest

        </div>

    </div>

</nav>