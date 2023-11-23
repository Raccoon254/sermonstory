<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'Laravel') }}</title> <!-- Using the title slot if set -->

        <!-- Adding meta description if set -->
        @isset($description)
            <meta name="description" content="{{ $description }}">
        @endisset

        <!--favicon as fontawesome icon-->
        <!--<path d="M6 22h15v-2H6.012C5.55 19.988 5 19.805 5 19s.55-.988 1.012-1H21V4a2 2 0 0 0-2-2H6c-1.206 0-3 .799-3 3v14c0 2.201 1.794 3 3 3zM8 7h3V5h2v2h3v2h-3v6h-2V9H8V7z"></path>-->
        <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 24 24'%3E%3Cpath d='M6 22h15v-2H6.012C5.55 19.988 5 19.805 5 19s.55-.988 1.012-1H21V4a2 2 0 0 0-2-2H6c-1.206 0-3 .799-3 3v14c0 2.201 1.794 3 3 3zM8 7h3V5h2v2h3v2h-3v6h-2V9H8V7z'/%3E%3C/svg%3E" type="image/svg+xml">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/af6aba113a.js" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex bg-gray-100">
{{--            <livewire:layout.navigation />--}}

            <!-- Page Heading -->
            @if (isset($header))
            @endif

                @include('layouts.sidebar')

                <!-- Page Content -->
                <main class="p-2 sm:p-4 w-full mt-14 overflow-clip">
                    <div class="absolute top-0 left-0 right-0 m-3 w-[50px] h-[50px] bottom-0">
                        <section data-tip="SideBar" class="tooltip tooltip-bottom m-0 p-0 shrink-0 flex items-center md:hidden">
                            <label for="my-drawer" class="drawer-button swap swap-rotate">

                                <!-- this hidden checkbox controls the state -->
                                <input class="hidden" type="checkbox" />

                                <i class="fa-solid text-xl text-gray-950 fa-bars"></i>

                            </label>
                        </section>
                    </div>

                    <!-- Session Alerts -->
                    @include('session.alerts')
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
