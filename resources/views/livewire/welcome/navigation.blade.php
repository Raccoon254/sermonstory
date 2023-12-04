<div class="flex gap-2 flex-col sm:flex-row fixed top-0 right-0 p-4 text-right z-10">
    @auth
        <a data-tip="Dashboard" href="{{ url('/dashboard') }}" class="btn bg-gray-700 text-gray-50 rounded btn-outline ring ring-inset font-semibold focus:outline-none focus:ring-2 focus:ring-red-500" wire:navigate>
            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
        </a>
    @else
        <a href="{{ route('login') }}" class="btn bg-gray-700 w-full sm:w-auto text-gray-50 rounded btn-outline ring ring-inset font-semibold focus:outline-none focus:ring-2 focus:ring-red-500" wire:navigate>
            <i class="fas fa-sign-in-alt mr-1"></i> Log in
        </a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="w-full bg-gray-700 sm:w-auto btn text-gray-50 rounded btn-outline ring ring-inset font-semibold focus:outline-none focus:ring-2 focus:ring-red-500" wire:navigate>
                <i class="fas fa-user-plus mr-1"></i> Register
            </a>
        @endif
    @endauth
</div>
