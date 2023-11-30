<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SermonStories™️</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/af6aba113a.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 antialiased">

@if (Route::has('login'))
    <livewire:welcome.navigation wire:key="navigation" />
@endif

<!-- Hero Section -->
<section class="bg-cover bg-center text-white relative h-[70vh] flex justify-center items-center" style="background-image: url('./a.jpg');">
    <div class="absolute inset-0 bg-black opacity-40"></div>
    <div class="relative z-10 text-center">
        <h1 class="sm:text-5xl text-4xl font-bold mb-4">SermonStories™️</h1>
        <p class="sm:text-xl text-sm">Bringing Bible Stories Closer to You</p>
    </div>
</section>

<!-- Featured Stories -->
<section class="py-12 sm:px-6 px-2">
    <h2 class="text-center text-3xl font-bold mb-8">Featured Stories</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 container mx-auto">
        <!-- Loop through the fetched stories -->
        @foreach($stories as $story)
            <div class="bg-white p-6 rounded shadow hover:shadow-lg">
                <h3 class="text-xl font-semibold mb-3">{{ $story->title }}</h3>
                <p>{{ Str::limit($story->content, 100) }}...</p>
                <a href="{{ route('register') }}" class="text-indigo-600 mt-2 inline-block">Read More</a>
            </div>
        @endforeach
    </div>
</section>


<!-- About/Mission Section -->
<section class="py-12 bg-gray-900 text-white">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6">Our Mission</h2>
        <p>At SermonStories™️, we strive to bring the timeless tales of the Bible to life, providing an immersive experience for believers and seekers alike. We believe that these stories have profound wisdom to impart, and our platform is dedicated to sharing that with the world.</p>
    </div>
</section>

<!-- Footer (You can add more to this) -->
<footer class="py-6 bg-gray-800 text-white">
    <div class="container mx-auto text-center">
        <p>&copy; 2023 SermonStories™️. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>
