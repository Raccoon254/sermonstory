<?php

use function Livewire\Volt\{state};
use Livewire\Volt\Component;
use App\Models\CategoryTag;
use Livewire\Attributes\Rule;
use App\Models\GptStory;
use App\Models\GptScripture;
use App\Models\Prompt;
use App\Models\Story;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OpenAI;

new class extends Component {

    #[Rule('required|min:5')]
    public $title = '';
    #[Rule('required|array|min:1|max:3')]
    public $selectedCategories = [];
    public $categories;

    public function mount()
    {
        $this->categories = CategoryTag::all();
    }

    public function generate(): void
    {
        $this->validate([
            'title' => 'required|min:5',
            'selectedCategories' => 'required|array|min:1|max:3',
        ]);

        // Convert selected category IDs to names
        $categoryNames = CategoryTag::whereIn('id', $this->selectedCategories)
            ->pluck('name')
            ->toArray();

        // Generate the story and associated content
        $generatedStory = $this->getOpenAIResponse("Craft a real-life story related to '" . implode(' and ', $categoryNames) . "'. Ensure the story is within 100 to 150 words.", 300);
        $lesson = $this->getOpenAIResponse("Based on the story: '$generatedStory', what moral lesson can we derive from it?", 200);
        $generatedTitle = $this->getOpenAIResponse("Based on the story: '$generatedStory' suggest a title. Ensure it's within 5 to 10 words.", 70);
        $verses = $this->getOpenAIResponse("Based on the story: '$generatedStory', suggest three Bible verses in JSON format.", 500);

        // Save the story and associated data to the database
        $storyModel = GptStory::create([
            'title' => $generatedTitle,
            'content' => $generatedStory,
            'moral_lesson' => $lesson,
        ]);

        // Save the verses
        $verseData = json_decode($verses, true);
        foreach ($verseData as $verse) {
            GptScripture::create([
                'story_id' => $storyModel->id,
                'verse' => $verse['verse'],
                'content' => $verse['content'],
            ]);
        }

        $storyModel->categoryTags()->attach($this->selectedCategories);

        // Update the UI with the generated content
        $this->dispatchBrowserEvent('storyGenerated', [
            'story' => $generatedStory,
            'lesson' => $lesson,
            'title' => $generatedTitle,
            'verses' => $verses
        ]);
    }

    private function getOpenAIResponse($prompt, $maxTokens)
    {
        // Assuming you have set up a service for OpenAI API calls
        $apiKey = ENV('OPENAI_API_KEY');
        $client = OpenAI::client($apiKey);

        $response = $client->completions()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => $prompt,
            'max_tokens' => $maxTokens,
        ]);

        return $response['choices'][0]['text'];
    }

    public function toggleCategory($categoryId): void
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

<div class="overflow-hidden rounded shadow-sm">

    <div wire:loading class="fixed top-0 left-0 w-full h-full bg-gray-300 backdrop-blur-sm bg-opacity-80 z-50 flex justify-center items-center">
        <div class="text-white flex items-center h-full justify-center text-lg font-semibold">
            <div class="loader">
                <span class="loading bg-orange-800 loading-ring loading-lg"></span>
            </div>
        </div>
    </div>

    <div class="p-2 sm:p-4 bg-gray-50 border-b border-gray-200">
        <h2 class="font-semibold text-center text-xl sm:text-2xl mb-4">Generate a Story</h2>
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
                <div class="flex flex-wrap relative">
                    @foreach($categories as $category)
                        <button type="button"
                                wire:click="toggleCategory({{ $category->id }})"
                                class="border rounded px-2 py-1 mr-1 mb-1 focus:outline-none
                           {{ in_array($category->id, $selectedCategories) ? 'bg-blue-500 text-white' : 'border-gray-300' }}
                           {{ count($selectedCategories) >= 3 && !in_array($category->id, $selectedCategories) ? 'bg-gray-200' : '' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                @error('selectedCategories')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <input type="hidden" name="selected_categories" value="{{ implode(',', $selectedCategories) }}">
            </div>

            <x-secondary-button type="submit" class="ring-blue-500 ring-2 hover:bg-gray-100">
                Generate Story

                <div wire:loading>
                    <i class="fas fa-spinner fa-spin"></i>
                </div>

            </x-secondary-button>
        </form>

        <!-- Display generated story -->
        @if(session('content'))
            <div class="mt-8 bg-gray-100 p-6 rounded border border-gray-200">
                <h3 class="font-bold text-lg mb-4">Generated Story:</h3>
                <p>{{ session('content')['story'] }}</p>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('content-generated', data => {
                // Update the UI with the generated story
                console.log(data.story); // Replace this with actual UI update logic
            });
        });
    </script>

</div>
