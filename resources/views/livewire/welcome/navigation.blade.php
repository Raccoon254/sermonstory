<div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
    @auth
        <a data-tip="Dashboard" href="{{ url('/dashboard') }}" class="btn text-gray-50 rounded btn-outline ring ring-inset font-semibold focus:outline-none focus:ring-2 focus:ring-red-500" wire:navigate>
            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
        </a>
    @else
        <a href="{{ route('login') }}" class="btn text-gray-50 rounded btn-outline ring ring-inset font-semibold focus:outline-none focus:ring-2 focus:ring-red-500" wire:navigate>
            <i class="fas fa-sign-in-alt mr-1"></i> Log in
        </a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 btn text-gray-50 rounded btn-outline ring ring-inset font-semibold focus:outline-none focus:ring-2 focus:ring-red-500" wire:navigate>
                <i class="fas fa-user-plus mr-1"></i> Register
            </a>
        @endif
    @endauth
</div>
