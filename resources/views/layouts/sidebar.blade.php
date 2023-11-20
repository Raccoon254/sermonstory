<div class="drawer w-0 md:w-64 md:drawer-open">
    <input id="my-drawer" type="checkbox" class="drawer-toggle" />
    <div class="">

    </div>
    <div class="z-40 drawer-side">
        <label for="my-drawer" class="drawer-overlay"></label>
        <div class="flex flex-col h-screen border-r border-gray-200 bg-gray-100 justify-between">

            <div class="test"></div>

            <div class="menu overflow-clip p-4 w-64 backdrop-blur-sm bg-gray-50 bg-opacity-30 text-base-content gap-4 flex flex-col justify-center items-center">
                <!-- App Logo -->
                <div class="flex items-center w-full justify-center gap-4">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block w-[60px] fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Sidebar content here -->
                <a href="{{ route('dashboard') }}" class="side {{ Route::is('home') ? 'active' : '' }}">
                    <i class="fa-solid fa-home-lg"></i>
                    <div class="">
                        Dashboard
                    </div>
                </a>

                <a href="{{ route('stories.index') }}" class="side {{ Route::is('stories.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-book"></i>
                    <div class="">
                        Stories
                    </div>
                </a>

                <a href="{{ route('about') }}" class="side {{ Route::is('about') ? 'active' : '' }}">
                    <i class="fa-solid fa-info"></i>
                    <div class="">
                        About
                    </div>
                </a>

                <a href="{{ route('profile') }}" class="side {{ Route::is('profile') ? 'active' : '' }}">
                    <i class="fa-regular fa-circle-user"></i>
                    <div class="">
                        Profile
                    </div>
                </a>

                @can('manage')

                    <a href="{{ route('stories.create') }}" class="side {{ Route::is('stories.create') ? 'active' : '' }}">
                        <i class="fa-solid fa-plus"></i>
                        <div class="">
                            Create
                        </div>
                    </a>

                @endcan


                <a class="side" href="">
                    <i class="fa-solid fa-bell"></i>
                    <div class="">
                        Notifications
                    </div>
                </a>


            </div>
            <div class="menu overflow-clip p-4 w-64 backdrop-blur-sm bg-gray-50 bg-opacity-30 text-base-content gap-4 flex flex-col justify-center items-center">
                <!--Logout-->
                @if(auth()->user())
                    <form class="w-full" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="side d-inline ring-1 ring-offset-1 bg-blue-500">
                            <i class="fa-solid fa-sign-out"></i>
                            Logout
                        </button>
                    </form>
                @endif
            </div>
        </div>

    </div>
</div>
