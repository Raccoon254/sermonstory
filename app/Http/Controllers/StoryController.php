<?php

namespace App\Http\Controllers;

use App\Models\CategoryTag;
use App\Models\Story;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
}
