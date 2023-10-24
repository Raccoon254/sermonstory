<?php

use function Livewire\Volt\{state};
use App\Models\CategoryTag;

state(['count' => 0, 'categories'=> CategoryTag::all()]);
$increment = fn () => $this->count++;

//logic to fetch the story here and show loading state

?>

<div class="overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-gray-50 border-b border-gray-200">
        <h2 class="font-semibold text-xl mb-4">Generate a Story</h2>
        <!--<div>
            <h1>Count {{ $count }}</h1>
            <button class="btn" wire:click="increment">ADD</button>
        </div> -->
        <form action="{{ route('generate.story') }}" method="post">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="title">Enter a title</label>
                <input type="text" name="title" id="title" class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ old('title') }}" placeholder="Title eg A story about Joe">
                @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Select Categories (Up to 3):</label>
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

            let selectedCategories = [];

            function toggleCategory(button) {
                let categoryId = button.getAttribute("data-category");
                let index = selectedCategories.indexOf(categoryId);

                if (index === -1) {
                    if (selectedCategories.length < 3) {
                        selectedCategories.push(categoryId);
                        button.classList.add("bg-blue-500", "text-white");
                    }
                    if (selectedCategories.length === 3) {
                        let buttons = document.querySelectorAll('[data-category]');
                        let unselectedButtons = Array.from(buttons).filter(function (button) {
                            return !button.classList.contains("bg-blue-500");
                        });
                        unselectedButtons.forEach(function (button) {
                            button.setAttribute("disabled", "disabled");
                            button.classList.add("bg-gray-200");
                        });
                    }
                } else {
                    selectedCategories.splice(index, 1);
                    button.classList.remove("bg-blue-500", "text-white");
                    let buttons = document.querySelectorAll('[data-category]');
                    buttons.forEach(function (button) {
                        button.removeAttribute("disabled");
                        button.classList.remove("bg-gray-200");
                    });
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
