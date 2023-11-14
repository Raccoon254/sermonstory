<?php

use function Livewire\Volt\{state};
use Livewire\Volt\Component;
use App\Models\CategoryTag;

new class extends Component {
    public $title = '';
    public $selectedCategories = [];
    public $count = 0;
    public $categories;

    public function mount()
    {
        $this->categories = CategoryTag::all();
    }

    public function increment()
    {
        $this->count++;
    }

    public function generate()
    {
        // Logic for story generation goes here
        // Use $this->title and $this->selectedCategories but convert array to string first
        sleep(5);
        $generatedStory = "Story generated based on: {$this->title} and categories: " . implode(',', $this->selectedCategories);

        // Assuming session is used to display the generated story
        session(['content' => ['story' => $generatedStory]]);
    }

    public function toggleCategory($categoryId)
    {
        if (($key = array_search($categoryId, $this->selectedCategories)) !== false) {
            unset($this->selectedCategories[$key]);
        } else {
            if (count($this->selectedCategories) < 3) {
                $this->selectedCategories[] = $categoryId;
            }
        }
    }
} ?>

<div class="overflow-hidden shadow-sm sm:rounded-lg">

    <div wire:loading class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 z-50 flex justify-center items-center">
        <div class="text-white flex items-center justify-center text-lg font-semibold">
            <div class="loader">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </div>
        </div>
    </div>

    <div class="p-6 bg-gray-50 border-b border-gray-200">
        <h2 class="font-semibold text-xl mb-4">Generate a Story</h2>
        <div>
            <h1>Count {{ $count }}</h1>
            <button class="btn" wire:click="increment">ADD</button>
        </div>
        <form wire:submit.prevent="generate">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="title">Enter a title</label>
                <input type="text" wire:model="title" class="border border-gray-300 rounded px-2 py-1 w-full" placeholder="Title eg A story about Joe">
                @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Categories -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Select Categories (Up to 3):</label>
                <div class="flex flex-wrap">
                    @foreach($categories as $category)
                        <button type="button"
                                wire:click="toggleCategory({{ $category->id }})"
                                class="border rounded px-2 py-1 mr-2 mb-2 focus:outline-none
                           {{ in_array($category->id, $selectedCategories) ? 'bg-blue-500 text-white' : 'border-gray-300' }}
                           {{ count($selectedCategories) >= 3 && !in_array($category->id, $selectedCategories) ? 'bg-gray-200' : '' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
                <input type="hidden" name="selected_categories" value="{{ implode(',', $selectedCategories) }}">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Generate Story

                <div wire:loading>
                    <i class="fas fa-spinner fa-spin"></i>
                </div>

            </button>
        </form>

        <!-- Display generated story -->
        @if(session('content'))
            <div class="mt-8 bg-gray-100 p-6 rounded border border-gray-200">
                <h3 class="font-bold text-lg mb-4">Generated Story:</h3>
                <p>{{ session('content')['story'] }}</p>
            </div>
        @endif
    </div>
</div>
