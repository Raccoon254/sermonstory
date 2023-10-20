<?php

namespace App\Http\Controllers;

use App\Models\CategoryTag;
use App\Models\GptCategory;
use App\Models\GptStory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GptStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $stories = GptStory::all();
        return view('gptstories.index', compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('generate.story');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $story = GptStory::findOrFail($id);
        return view('gptstories.show', compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $story = GptStory::findOrFail($id);
        $categoryTags = CategoryTag::all();
        return view('gptstories.edit', compact('story', 'categoryTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $story = GptStory::findOrFail($id);
        $story->update($request->only('title', 'content', 'moral_lesson'));
        foreach ($request->scriptures as $scriptureContent) {
            $story->scriptures()->create(['content' => $scriptureContent]);
        }
        $story->categoryTags()->sync($request->category_tags);
        return redirect()->route('gptstories.index')->with('success', 'Story updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $story = GptStory::findOrFail($id);
        $story->delete();
        return redirect()->route('gptstories.index')->with('success', 'Story deleted successfully.');
    }
}
