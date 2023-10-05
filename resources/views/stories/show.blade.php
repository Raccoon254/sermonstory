<x-app-layout>
        <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative" style="background-image: url('https://img.freepik.com/free-photo/open-book-blue-background-isolated-closeup_169016-25939.jpg?w=996&t=st=1696513760~exp=1696514360~hmac=6d4a3ef45116ce9a2109de6c49d0103bdca2d1afa630d5bece98af0ceea3c510');">
            <!-- Use a semi-transparent overlay to make the text more readable -->
            <div class="absolute inset-0 bg-black opacity-40"></div>

            <div class="relative z-10 max-w-2xl p-6 backdrop-blur-sm bg-base-100 bg-opacity-10 rounded shadow-lg">
                <h1 class="text-3xl font-semibold mb-4">{{ $story->title }}</h1>
                <p class="mb-4">{{ $story->content }}</p>
                <p><strong>Moral Lesson:</strong> {{ $story->moral_lesson }}</p>

                @if($story->scriptures->count())
                    <div class="mt-4">
                        <h2 class="text-xl font-semibold mb-2">Scriptures:</h2>
                        @foreach($story->scriptures as $scripture)
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
                        <a href="{{ route('stories.index') }}" class="btn btn-outline btn-ghost h-10 rounded-0  ring ring-inset ring-white">Back</a>
                    </div>

                </div>
            </div>
        </div>

</x-app-layout>
