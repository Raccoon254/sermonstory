<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="font-bold text-xl mb-4">Generate a Story</h2>

                <form action="{{ route('generate.story') }}" method="post">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Select Categories (Up to 3):</label>
                        <div class="flex flex-wrap">
                            @foreach($categories as $category)
                                <button type="button" class="border border-gray-300 rounded px-2 py-1 mr-2 mb-2 focus:outline-none" onclick="toggleCategory(this)" data-category="{{ $category->id }}">{{ $category->name }}</button>
                            @endforeach
                        </div>
                        <input type="hidden" name="selected_categories" id="selected_categories" value="">
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Generate Story
                    </button>
                </form>

                <script>

                    var selectedCategories = [];

                    function toggleCategory(button) {
                        var categoryId = button.getAttribute("data-category");
                        var index = selectedCategories.indexOf(categoryId);

                        if (index === -1) {
                            if (selectedCategories.length < 3) {
                                selectedCategories.push(categoryId);
                                button.classList.add("bg-blue-500", "text-white");
                            }
                        } else {
                            selectedCategories.splice(index, 1);
                            button.classList.remove("bg-blue-500", "text-white");
                        }

                        // Update the hidden input with selected categories
                        document.getElementById("selected_categories").value = selectedCategories.join(",");
                    }
                </script>


                @if(session('content'))
                    <div class="mt-8 bg-gray-100 p-6 rounded border border-gray-200">
                        <h3 class="font-bold text-lg mb-4">Generated Story:</h3>
                        <p>{{ session('content')['story'] }}</p>

                        <h3 class="font-bold text-lg mb-4 mt-6">Moral Lesson:</h3>
                        <p>{{ session('content')['lesson'] }}</p>


                        @php
                            $verses = session('content')['verses'];
                            $versesArray = json_decode($verses, true);
                        @endphp

                        @if($versesArray)
                            @foreach($versesArray as $key => $verseData)
                                <h4>{{ ucfirst($key) }}</h4>
                                <p><strong>{{ $verseData['verse'] }}</strong>: {{ $verseData['content'] }}</p>
                            @endforeach
                        @else
                            <p>There was an error decoding the verses.</p>
                        @endif

                    </div>
                @endif





            </div>
        </div>
    </div>
</x-app-layout>
