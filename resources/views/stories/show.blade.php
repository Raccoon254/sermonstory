<x-app-layout>

    <!--title and meta description-->
    <x-slot name="title">{{ $story->title }}</x-slot>
    <x-slot name="description">{{ Str::limit($story->content, 160) }}</x-slot> <!-- Limiting description to 160 chars -->


    <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative">
            <!-- Use a semi-transparent overlay to make the text more readable -->
            <div class="absolute inset-0 bg-gray-50 rounded opacity-40"></div>

            <div class="relative z-10 max-w-2xl p-4 backdrop-blur-sm bg-base-100 bg-opacity-10 rounded shadow-sm">
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
                        <h2 class="text-xl font-semibold mb-2">Scriptures:</h2>
                        @foreach($story->scriptures as $scripture)
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

                <div class="flex text-xs gap-1 justify-start items-center">

                    <div class="mt-4">
                        <a href="{{ route('stories.index') }}">
                            <button class="btn btn-outline btn-sm h-10 rounded-0  ring-1 ring-offset-1 ring-inset ring-blue-500 normal-case">
                                <i class="fa-regular fa-circle-left"></i> Back
                            </button>
                        </a>
                    </div>

                </div>
<!--Related Stories-->
@php
    $relatedStories = $story->relatedStories();
@endphp

@if($relatedStories->count())
    <div class="mt-32">
        <h2 class="text-xl font-semibold mb-2">Related Stories:</h2>
        <div class="grid grid-cols-1 gap-4">
            @foreach($relatedStories as $relatedStory)
                <div class="p-4 border-b-2 border-gray-300">
                    <h3 class="text-lg font-semibold mb-2">{{ $relatedStory->title }}</h3>
                    <p>{{ Str::limit($relatedStory->content, 100) }}</p>
                    <a href="{{ route('stories.show', $relatedStory) }}" class="text-blue-500 mt-2 inline-block">Read More</a>
                </div>
            @endforeach
        </div>
    </div>
@endif
            </div>
        </div>

</x-app-layout>
