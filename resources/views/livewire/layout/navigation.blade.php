<?php

use Livewire\Volt\Component;

new class extends Component
{
    public function logout(): void
    {
        auth()->guard('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/', navigate: true);
    }
};
?>

<nav class="bg-white border-b border-gray-100">

    <header class="flex justify-between items-center p-3">

        <section class="start">

        </section>

        <nav class="flex gap-3">
            <a href="{{ route('home') }}" class="{{ Route::currentRouteName() == 'home' ? 'text-blue-500' : '' }}">Home</a>
            <a href="{{ route('dashboard') }}" class="{{ Route::currentRouteName() == 'dashboard' ? 'text-blue-500' : '' }}">Dashboard</a>
            <a href="{{ route('stories.index') }}" class="{{ Route::currentRouteName() == 'stories.index' ? 'text-blue-500' : '' }}">Stories</a>
            <a href="{{ route('about') }}" class="{{ Route::currentRouteName() == 'about' ? 'text-blue-500' : '' }}">About</a>
            @can('manage')
                <a href="{{ route('stories.create') }}" class="{{ Route::currentRouteName() == 'stories.create' ? 'text-blue-500' : '' }}">Create</a>
            @endcan
        </nav>

        <section class="flex end justify-end">

            @if(auth()->user())
                <form wire:submit.prevent="logout" class="d-inline">
                    <button type="submit" class="btn btn-circle btn-sm btn-outline">
                        <i class="fa-solid fa-sign-out"></i>
                    </button>
                </form>
            @endif

        </section>

    </header>


</nav>
