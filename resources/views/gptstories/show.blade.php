<x-app-layout>

    <!--title and meta description-->
    <x-slot name="title">{{ $story->title }}</x-slot>
    <x-slot name="description">{{ Str::limit($story->content, 160) }}</x-slot> <!-- Limiting description to 160 chars -->


    <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative">
        <!-- Use a semi-transparent overlay to make the text more readable -->
        <div class="absolute inset-0 bg-gray-50 rounded opacity-40"></div>

        <div class="relative z-10 max-w-2xl p-6 backdrop-blur-sm bg-base-100 bg-opacity-10 rounded shadow-sm">
            <h1 class="text-3xl font-semibold mb-4">{{ $story->title }}</h1>
            <p class="mb-4">{{ $story->content }}</p>

            @if($story->moral_lesson)
                <div class="mt-4">
                    <h2 class="text-xl font-semibold mb-2">Moral Lesson:</h2>
                    <p>{{ $story->moral_lesson }}</p>
                </div>
            @endif


            @if($story->scriptures->count())
                <div class="mt-4">
                    <h1 class="font-semibold mb-2">Scriptures:</h1>
                    @foreach($story->scriptures as $scripture)
                        <h2 class="text-xl font-semibold">{{ $scripture->verse }}</h2>
                        <p class="mb-2">{{ $scripture->content }}</p>
                    @endforeach
                </div>
            @endif

            @if($story->conclusion)
                <div class="mt-4">
                    <h2 class="text-xl font-semibold mb-2">Conclusion:</h2>
                    <p>{{ $story->conclusion }}</p>
                </div>
            @endif

            <div class="flex justify-between items-center">
                @if($story->categoryTags->count())
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($story->categoryTags as $tag)
                            <span class="tag bg-gray-200 p-1 rounded">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('stories.index') }}">
                        <button class="btn btn-sm btn-outline btn-secondary h-10 rounded-0  ring-1 ring-offset-1 ring-inset ring-blue-500 normal-case">
                            <i class="fa-regular fa-circle-left"></i> Back
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
