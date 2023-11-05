<div class="drawer w-0 md:w-64 md:drawer-open">
    <input id="my-drawer" type="checkbox" class="drawer-toggle" />
    <div class="">

    </div>
    <div class="z-40 drawer-side">
        <label for="my-drawer" class="drawer-overlay"></label>

        <div class="menu overflow-clip p-4 w-64 h-full backdrop-blur-sm bg-gray-500 bg-opacity-30 border-r border-gray-200 text-base-content gap-4 flex flex-col justify-center items-center">
            <!-- App Logo -->
            <div class="flex items-center w-full justify-center gap-4">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block w-[60px] fill-current text-gray-800" />
                </a>
            </div>

            <!-- Sidebar content here -->
            <a href="{{ route('dashboard') }}" class="side {{ Route::is('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-home-lg"></i>
                <div class="">
                    Dashboard
                </div>
            </a>

            <a href="{{ route('profile') }}" class="side {{ Route::is('profile') ? 'active' : '' }}">
                <i class="fa-regular fa-circle-user"></i>
                <div class="">
                    Profile
                </div>
            </a>

            <a class="side" href="" >
                <i class="fa-solid fa-bell"></i>
                <div class="">
                    Notifications
                </div>
            </a>


        </div>
    </div>
</div>