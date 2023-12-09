<?php

use function Livewire\Volt\{state};
use Livewire\Volt\Component;
use App\Models\CategoryTag;
use Livewire\Attributes\Rule;
use App\Models\GptStory;
use App\Models\GptScripture;
use Illuminate\Support\Facades\DB;

new class extends Component {

    #[Rule('required|min:5')]
    public $title = '';
    #[Rule('required|array|min:1|max:3')]
    public $selectedCategories = [];
    public $categories;
    public $generatedStory = '';
    public $lesson = '';
    public $generatedTitle = '';
    public $conclusion = '';
    public $verses = '';
    public bool $showStory = false;

    public function mount(): void
    {
        $this->categories = CategoryTag::all();
    }

    public function generate(): void
    {
        $this->showStory = false;

        $this->validate([
            'title' => 'required|min:5',
            'selectedCategories' => 'required|array|min:1|max:3',
        ]);

        DB::beginTransaction();

        try {

            // Convert selected category IDs to names
            $categoryNames = CategoryTag::whereIn('id', $this->selectedCategories)
                ->pluck('name')
                ->toArray();

            // Generate the story and associated content
            $this->generatedStory = $this->getOpenAIResponse("Craft a real-life story related to '" . implode(' and ', $categoryNames) . "'. Ensure the story is within 100 to 150 words.", 300);

            $this->showStory = true;

            $this->conclusion = $this->getOpenAIResponse("Based on the story: ' $this->generatedStory', what conclusion can we draw from it?", 200);

            $this->lesson = $this->getOpenAIResponse("Based on the story: ' $this->generatedStory', what moral lesson can we derive from it?", 200);

            $this->generatedTitle = $this->getOpenAIResponse("Based on the story: ' $this->generatedStory' suggest a title. Ensure it's within 5 to 10 words.", 70);

            $this->verses = $this->getOpenAIResponse("Based on the story: ' $this->generatedStory', suggest three Bible verses in JSON format.{
            \"verse1\": {
                \"verse\": \"Matthew 1:1\",
                \"content\": \"Example content for verse 1\"
            },
            \"verse2\": {
                \"verse\": \"Matthew 1:2\",
                \"content\": \"Example content for verse 2\"
            },
            \"verse3\": {
                \"verse\": \"Matthew 1:3\",
                \"content\": \"Example content for verse 3\"
            }
        }", 500);

            // Save the story and associated data to the database
            $storyModel = GptStory::create([
                'title' =>  $this->generatedTitle,
                'content' =>  $this->generatedStory,
                'moral_lesson' =>  $this->lesson,
                'conclusion' =>  $this->conclusion,
            ]);


            //if verses is null, set it to empty array
            if($this->verses == null){
                $this->verses = "[]";
            }

            $verseData = json_decode($this->verses, true);

            if ($verseData == null) {
                $verseData = [];
            }else{
                foreach ($verseData as $verseItem) {
                    GptScripture::create([
                        'story_id' => $storyModel->id,
                        'verse' => $verseItem['verse'],
                        'content' => $verseItem['content'],
                    ]);
                }
            }


            $storyModel->categoryTags()->attach($this->selectedCategories);
            DB::commit();

            // UI update logic...
        } catch (Exception $e) {
            DB::rollBack();
            // Handle the exception, e.g., log the error or return an error message
        }

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
}
?>

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
        <!--If showStory is true, display an alert-->
        @if($showStory)
            <div role="alert" class="alert rounded alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Story generated successfully!</span>
                <a href="#story" class="text-blue-500 hover:underline">Scroll to the story</a>
            </div>
        @endif
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
                                class="border text-sm hover:bg-blue-400 rounded px-2 py-1 mr-1 mb-1 focus:outline-none
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

        <!--if showStory is true, display the story-->

        @if($showStory)
            <div id="story" class="p-2 bg-gray-100 flex flex-col gap-3 rounded mt-4">
                <div class="top mb-2">
                    <h3 class="text-center text-2xl font-semibold">{{ $generatedTitle }}</h3>
                    <p>
                        {{ $generatedStory }}
                    </p>
                </div>
                <div class="mid mb-2">
                    <h3 class="text-center text-2xl font-semibold">Moral Lesson</h3>
                    <p>
                        {{ $lesson }}
                    </p>
                </div>

                <div class="Bottom">

                    <h3 class="text-center text-2xl font-semibold">Scriptures</h3>
                    @php
                        $versesArray = json_decode($verses, true);
                        if ($versesArray) {
                            foreach ($versesArray as $verse) {
                                echo "<p><strong>Verse:</strong> " . $verse['verse'] . "</p>";
                                echo "<p><strong>Content:</strong> " . $verse['content'] . "</p>";
                            }
                        }
                    @endphp
                </div>

                <div class="Bottom">
                    <h3 class="text-center text-2xl font-semibold">Conclusion</h3>
                    <p>
                        {{ $conclusion }}
                    </p>
                </div>
            </div>
        @endif

    </div>


</div>
