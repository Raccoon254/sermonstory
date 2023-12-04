<?php

use App\Models\Story;
use function Livewire\Volt\{state};
use App\Models\CategoryTag;

state(['categories' => CategoryTag::all()]);
state(['search' => '', 'stories' => Story::all()]);
state(['selectedCategory' => '']);

$updateSearch = function ($search) {
    $this->search = $search;
    $this->stories = Story::where('content', 'LIKE', '%' . $this->search . '%')->get();
};

$performSearch = function () {
    $this->stories = Story::where('content', 'LIKE', '%' . $this->search . '%')->get();
};

$filterByCategory = function ($categoryId) {
    $this->selectedCategory = CategoryTag::find($categoryId);
    $this->stories = Story::whereHas('categoryTags', function ($query) use ($categoryId) {
        $query->where('id', $categoryId);
    })->get();
};

$resetFilter = function () {
    $this->stories = Story::all();
};

?>

<div>
    <section>
        <center class="text-[2rem] my-2 font-semibold">Explore {{$selectedCategory->name ?? ''}} Stories</center>
        @if (count($stories))
            <section class="gap-3 flex md:px-20 sm:px-2 flex-col">

                <div class="w-full my-2">
                <div class="flex justify-end w-full">
                    <div class="w-48 rounded-full relative">
                        <label class="relative">
                            <input class="h-8 w-full rounded-full input-bordered" wire:keydown="updateSearch($event.target.value)" type="text" placeholder="Search for stories">
                            <span class="absolute top-[-5px] left-[15px] text-[7px] text-gray-300">Powered by Raccoon254</span>
                        </label>
                        <button wire:click="performSearch" class="h-6 w-8 flex items-center justify-center border-l border-gray-600 absolute top-[4px] right-1 text-[15px] hover:text-[20px] hover:text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                        </button>
                    </div>
</div>
                    <div class="category-buttons flex py-1 overflow-auto">
                            <button class="btn btn-primary ring-1 ring-secondary ring-offset-1 rounded m-1 btn-xs" wire:click="resetFilter">All Stories</button>
                        @foreach ($categories as $category)
                            <button class="btn ring-1 ring-gray-700 ring-offset-1 rounded m-1 btn-xs" wire:click="filterByCategory('{{ $category->id }}')" class="btn">
                                {{ $category->name }}
                            </button>
                        @endforeach

                    </div>

                </div>

                @foreach ($stories as $story)
                    <div class="story-card border-b-2">
                        <h2 class="text-xl mb-3 font-semibold">{{ $story['title'] }}</h2>
                        <p class="mb-3">{{ $story['content'] }}..
                            <a href="{{ route('stories.show', $story) }}" class="text-blue-500">Read More</a>
                        </p>

                        <div class="flex justify-end gap-2 mb-3">

                            <div class="flex tooltip gap-3 mb-3">

                            </div>

                            @if(auth()->user() && Gate::allows('manage'))

                                <div data-tip="Edit Story" class="flex tooltip gap-3 mb-3">
                                    <a href="{{ route('stories.edit', $story) }}" class="btn ring-1 ring-offset-1 ring-inset">
                                        <i class="fa-solid fa-pen-nib"></i>
                                    </a>
                                </div>

                                <form data-tip="Delete Story" action="{{ route('stories.destroy', $story) }}" method="POST" class="d-inline tooltip">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn ring-1 ring-offset-1 ring-inset ring-orange-600">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                            @endif

                        </div>


                    </div>
                @endforeach

                <div class="w-full custom flex justify-between">
{{--                    {{ $filteredStories->links() }}--}}
                </div>
            </section>
        @else
            <div class="h-[50vh] flex flex-col justify-center items-center">
                <center>No stories found</center>
                <button class="btn-outline rounded ring-1 ring-offset-1 btn-xs" wire:click="resetFilter">Show All Stories</button>

            </div>
        @endif
        <section class="gap-3 flex md:px-20 sm:px-2 flex-col">

        </section>
    </section>
    </div>
