<?php

namespace App\Http\Controllers;

use App\Models\CategoryTag;
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
        $stories = Story::take(3)->get();
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

        $story = Story::create($request->only('title', 'content', 'moral_lesson'));

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
    public function show(string $id)
    {
        $story = Story::findOrFail($id);
        return view('stories.show', compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
        return view('stories.generate');
    }

    public function generate(Request $request): RedirectResponse
    {
        $promptUser = $request->input('prompt');

// 1. Generate the story.
        $storyPrompt = "Craft a real-life, third-person narrative related to '" . $promptUser . "'. Ensure the story is within 100 to 150 words and carries a moral lesson that can be related to biblical principles dont write the moral lesson and the bible verses, just the story.";
        $story = $this->getOpenAIResponse($storyPrompt, 300);


        // 2. Extract the lesson from the story.
        $lessonPrompt = "Based on the story: '" . $story . "', what moral lesson can we derive from it?";
        $lesson = $this->getOpenAIResponse($lessonPrompt, 150);

        // 3. Extract the Bible verses supporting the story.
        $versePrompt = "Based on the lesson derived from the story: '" . $story ."', suggest three Bible verses that support the moral lesson. Return the verses in a structured JSON format. Example format:
            {
                'verse1': {
                    'verse': 'Matthew 1:1',
                    'content': 'this is the content of the verse'
                },
                'verse2': {
                    'verse': 'Matthew 1:2',
                    'content': 'this is the content of the verse'
                },
                'verse3': {
                    'verse': 'Matthew 1:3',
                    'content': 'this is the content of the verse'
                }
            }";
        $verses = $this->getOpenAIResponse($versePrompt, 500);

        $generatedContent = [
            'story' => $story,
            'lesson' => $lesson,
            'verses' => $verses
        ];

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
