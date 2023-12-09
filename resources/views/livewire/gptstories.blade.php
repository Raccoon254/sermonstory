<?php
use App\Models\GptStory;
use function Livewire\Volt\{state};

state(['search' => '', 'stories' => GptStory::all()]);
use App\Models\GptCategory;

state(['categories' => GptCategory::all()]);
state(['selectedCategories' => []]);
state(['filteredStories' => []]);
state(['selectedCategoriesString' => 'All Stories']);

$updateSearch = function ($search) {
    $this->search = $search;
    $this->stories = GptStory::where('content', 'LIKE', '%' . $this->search . '%')->get();
};

$performSearch = function () {
    $this->stories = null;
    $this->filteredStories = null;
    $this->filterByCategory($this->selectedCategories);
};

$filterByCategory = function ($categoryIds) {
    if (!is_array($categoryIds)) {
        $categoryIds = explode(',', $categoryIds);
    }

    $this->selectedCategories = $categoryIds;

    //if no categories are selected, show all stories
    if (count($categoryIds) == 0) {
        $this->stories = Story::all();
        return;
    }

    //GET ALL STORIES WITH THE SELECTED CATEGORIES for each category
    $this->stories = collect([]);
    foreach ($categoryIds as $categoryId) {
        $category = GptCategory::find($categoryId);
        //get the stories for this category
        $stories = $category->stories;
        //add the stories to the stories array
        $this->stories = $this->stories->merge($stories);
    }

    //remove duplicates
    $this->stories = $this->stories->unique('id');
};

$handleCheckboxClick = function ($categoryId, $isChecked) {
    if ($isChecked) {
        if (!in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories[] = $categoryId;
        }
    } else {
        $index = array_search($categoryId, $this->selectedCategories);
        if ($index !== false) {
            unset($this->selectedCategories[$index]);
        }
    }
    $this->updateSelectedCategoriesString();
};

$updateSelectedCategoriesString = function () {
    $selectedCategoriesIds = $this->selectedCategories;
    foreach ($selectedCategoriesIds as $index => $categoryId) {
        $category = GptCategory::find($categoryId);
        $selectedCategoriesIds[$index] = $category->name;
    }
    $this->selectedCategoriesString = implode(', ', $selectedCategoriesIds);
};

$resetFilter = function () {
    $this->stories = GptStory::all();
};

?>

<div>
    <section>
        <center class="text-[2rem] my-2 font-semibold">
            Generative Stories
        </center>
        @if (count($stories))
            <section class="gap-3 flex md:px-20 sm:px-2 flex-col">

                <div class="w-full my-2">
                    <div class="flex justify-end w-full">
                        <div class="w-48 rounded-full relative">
                            <label class="relative">
                                <input class="h-8 w-full text-xs rounded-full input-bordered"
                                       wire:keydown="updateSearch($event.target.value)" type="text"
                                       placeholder="Search for stories" value="{{ $selectedCategoriesString }}"/>
                                <span class="absolute top-[-5px] left-[15px] text-[7px] text-gray-300">Powered by Raccoon254</span>
                            </label>
                            <button wire:click="performSearch"
                                    class="h-6 w-8 flex items-center justify-center border-l border-gray-600 absolute top-[4px] right-1 text-[15px] hover:text-[20px] hover:text-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                    <path
                                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="category-buttons-container relative overflow-hidden">
                        <div class="arrow left hidden ring absolute top-0 bottom-0 flex items-center">
                            <i class="fa-solid arrow-l fa-chevron-left"></i>
                        </div>
                        <div class="category-buttons pl-20 flex text-xs py-1 overflow-auto">
                            <button class="absolute left-0 ring-1 h-8 btn btn-sm ring-offset-1 rounded mx-2"
                                    wire:click="performSearch">
                                Apply
                            </button>
                            @foreach ($categories->sortBy('name') as $category)
                                <button
                                    class="{{ in_array($category->id, $selectedCategories) ? 'active' : '' }} flex items-center px-1 ring-1 h-8 ring-gray-400 mr-2 rounded"
                                    wire:click="handleCheckboxClick('{{ $category->id }}', {{ in_array($category->id, $selectedCategories) ? 'false' : 'true' }})">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                        <div class="arrow right absolute ring top-0 bottom-0 right-0 flex items-center">
                            <i class="fa-solid arrow-r fa-chevron-right"></i>
                        </div>
                    </div>
                </div>

                @foreach ($stories as $story)
                    <div class="story-card border-b-2">
                        <h2 class="text-xl mb-3 font-semibold">{{ $story['title'] }}</h2>
                        <!-- Only show the first 100 characters of the story -->
                        <p>{{ Str::limit($story['content'], 300) }}
                            <a href="{{ route('gptstories.show', $story) }}" class="text-blue-500">Read More</a>
                        </p>

                        <div class="flex justify-end gap-2 mb-3">

                            <div class="flex tooltip gap-3 mb-3">

                            </div>

                            @if(auth()->user() && Gate::allows('manage'))

                                <div data-tip="Edit Story" class="flex tooltip gap-1 mb-3">
                                    <a href="{{ route('stories.edit', $story) }}"
                                       class="btn ring-1 btn-circle btn-sm ring-offset-1 ring-inset">
                                        <i class="fa-solid fa-pen-nib"></i>
                                    </a>
                                </div>

                                <form data-tip="Delete Story" action="{{ route('stories.destroy', $story) }}"
                                      method="POST" class="d-inline tooltip">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-circle btn-sm ring-1 ring-offset-1 ring-inset ring-orange-600">
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
                <button class="btn-outline rounded ring-1 ring-offset-1 btn-xs" wire:click="resetFilter">Show All
                    Stories
                </button>

            </div>
        @endif
        <section class="gap-3 flex md:px-20 sm:px-2 flex-col">

        </section>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var container = document.querySelector('.category-buttons');
            var leftArrow = document.querySelector('.arrow.left');
            var rightArrow = document.querySelector('.arrow.right');

            container.addEventListener('scroll', function () {
                if (container.scrollLeft > 0) {
                    leftArrow.classList.remove('hidden');
                } else {
                    leftArrow.classList.add('hidden');
                }

                if (container.scrollLeft < container.scrollWidth - container.clientWidth) {
                    rightArrow.classList.remove('hidden');
                } else {
                    rightArrow.classList.add('hidden');
                }
            });

            leftArrow.addEventListener('click', function () {
                container.scrollLeft -= 100;
            });

            rightArrow.addEventListener('click', function () {
                container.scrollLeft += 100;
            });
        });
    </script>
</div>
