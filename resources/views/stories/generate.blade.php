<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="font-bold text-xl mb-4">Generate a Story</h2>

                <form action="{{ route('generate.story') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="prompt" class="block text-gray-700 text-sm font-bold mb-2">Story Prompt:</label>
                        <textarea name="prompt" id="prompt" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Generate Story
                    </button>
                </form>

                <!-- Display the story if available -->
                @if(session('story'))
                    <div class="mt-8 bg-gray-100 p-6 rounded border border-gray-200">
                        <h3 class="font-bold text-lg mb-4">Generated Story:</h3>
                        <p>{{ session('story') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
