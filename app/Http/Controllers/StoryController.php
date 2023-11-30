<?php

namespace App\Http\Controllers;

use App\Models\CategoryTag;
use App\Models\GptScripture;
use App\Models\GptStory;
use App\Models\Prompt;
use App\Models\Story;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OpenAI;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $stories = Story::all();
        return view('stories.index', compact('stories'));
    }

    public function home(): View
    {
        //Get random 3 stories
        $stories = Story::inRandomOrder()->limit(3)->get();
        return view('welcome', compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categoryTags = CategoryTag::all();
        return view('stories.create', compact('categoryTags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $story = Story::create($request->only('title', 'content', 'moral_lesson', 'conclusion'));

        // Save scriptures
        foreach ($request->scriptures as $scriptureContent) {
            $story->scriptures()->create(['content' => $scriptureContent]);
        }

        // Attach category tags
        $story->categoryTags()->attach($request->category_tags);

        return redirect()->route('stories.index')->with('success', 'Story created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $story = Story::findOrFail($id);
        return view('stories.show', compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $story = Story::findOrFail($id);
        $categoryTags = CategoryTag::all();
        return view('stories.edit', ['story' => $story, 'categoryTags' => $categoryTags]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $story = Story::findOrFail($id);
        $story->update($request->only('title', 'content', 'moral_lesson'));

        // Update scriptures (for simplicity, we'll delete and recreate them)
        $story->scriptures()->delete();
        foreach ($request->scriptures as $scriptureContent) {
            $story->scriptures()->create(['content' => $scriptureContent]);
        }

        // Update category tags
        $story->categoryTags()->sync($request->category_tags);

        return redirect()->route('stories.index')->with('success', 'Story updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $story = Story::findOrFail($id);
        $story->delete();
        return redirect()->route('stories.index')->with('success', 'Story deleted successfully.');
    }

    public function generateStory(): View
    {
        $categories = CategoryTag::all();
        return view('stories.generate')->with('categories', $categories);
    }

    public function generate(Request $request): RedirectResponse
    {
        $title = $request->title;

        if (!$title) {
            return back()->with('error', 'Please enter a title.');
        }

        //if no categories are selected, return an error
        if (!$request->selected_categories) {
            return back()->with('error', 'Please select at least one category.');
        }

        // Get selected category IDs from the request
        $selectedCategoryIds = explode(',', $request->selected_categories);

        // Get the category names based on the selected IDs
        $selectedCategories = CategoryTag::whereIn('id', $selectedCategoryIds)->pluck('name')->toArray();

        //change selected categories to array
        $selectedCategoriesArray = explode(',', $request->selected_categories);

        // Join the category names into a comma-separated string (if needed)
        $selectedCategoryNames = implode(' and ', $selectedCategories);
        //dd($selectedCategoryNames);

        $todayPromptsCount = $request->user()->prompts()->whereDate('created_at', today())->count();

        if ($todayPromptsCount >= 5) {
            return back()->with('error', 'You have reached the daily limit of 5 prompts.');
        }

        // 1. Generate the story
        $storyPrompt = "Craft a real-life story related to '" . $selectedCategoryNames . "'. Ensure the story is within 100 to 150 words and carries a moral lesson that can be related to biblical principles dont write the moral lesson and the bible verses, just the story. The users title is '" . $title . "'";
        $story = $this->getOpenAIResponse($storyPrompt, 300);


        // 2. Extract the lesson from the story.
        $lessonPrompt = "Based on the story: '" . $story . "', what moral lesson can we derive from it?";
        $lesson = $this->getOpenAIResponse($lessonPrompt, 200);

        // 3. Generate a title for the story.
        $titlePrompt = "Based on the story: '" . $story . "' and '" .$selectedCategoryNames. "' then suggest a title for the story. Ensure the title is relevant to the story and within 5 to 10 words.";
        $title = $this->getOpenAIResponse($titlePrompt, 70);

        // 4. Extract the Bible verses supporting the story.
        $versePrompt = "Based on the story: '" . $story . "' and '" .$selectedCategoryNames. "' then suggest three Bible verses that support the moral lesson. Return the verses in a structured JSON format. Ensure each verse is distinct and relevant to the lesson. Use the following format:
        {
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
        }";

        $verses = $this->getOpenAIResponse($versePrompt, 500);

        $generatedContent = [
            'story' => $story,
            'lesson' => $lesson,
            'verses' => $verses
        ];

        $storyModel = GptStory::create([
            'title' => $title,
            'content' => $story,
            'moral_lesson' => $lesson,
        ]);

        // Save the verses associated with the story.
        $verseData = json_decode($verses, true);

        foreach ($verseData as $verse) {
            GptScripture::create([
                'story_id' => $storyModel->id,
                'verse' => $verse['verse'],
                'content' => $verse['content'],
            ]);
        }

        $storyModel->categoryTags()->attach($selectedCategoriesArray);

        $userRequest = $title . ' ' . $selectedCategoryNames;

        $request->user()->prompts()->create(['content' => $userRequest]);

        return back()->with('content', $generatedContent ?? 'No content generated');

    }

    private function getOpenAIResponse($prompt, $maxTokens)
    {
        $apiKey = ENV('OPENAI_API_KEY');
        $client = OpenAI::client($apiKey);

        $response = $client->completions()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => $prompt,
            'max_tokens' => $maxTokens,
        ]);

        return $response['choices'][0]['text'];
    }

}
