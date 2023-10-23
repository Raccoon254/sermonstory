<x-app-layout>
        <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative">
            <!-- Use a semi-transparent overlay to make the text more readable -->
            <div class="absolute inset-0 bg-black opacity-40"></div>

            <div class="relative z-10 max-w-2xl p-6 my-5  backdrop-blur-sm bg-base-100 bg-opacity-10 rounded shadow-lg">

                <h1 class="text-3xl font-semibold mb-4">{{ $story->title }}</h1>
                <p class="mb-4">{{ $story->content }}</p>
                <h1 class="font-semibold">Moral Lesson</h1>
                <p>{{ $story->moral_lesson }}</p>

                @if($story->scriptures->count())
                    <div class="mt-4">
                        <h1 class="font-semibold mb-2">Scriptures:</h1>
                        @foreach($story->scriptures as $scripture)
                            <h2 class="text-xl font-semibold">{{ $scripture->verse }}</h2>
                            <p class="mb-2">{{ $scripture->content }}</p>
                        @endforeach
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
                        <a href="{{ route('gptstories.index') }}">
                            <button class="btn btn-outline btn-ghost h-10 rounded-0  ring ring-inset ring-white">
                                <i class="fa-regular fa-circle-left"></i> Back
                            </button>
                        </a>
                    </div>

                </div>
            </div>
        </div>

</x-app-layout>
