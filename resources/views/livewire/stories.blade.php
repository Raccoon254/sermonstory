<div>
    <section>
        <div class="w-full">
            <div class="w-full relative sm:w-1/4 sm:mx-4">
                <label class="relative">
                    <input class="input ordered h-10 w-full" wire:model="search" type="text" placeholder="Search for stories">
                    <span class="absolute top-[-10px] left-1 text-[8px] text-gray-300">Powered by Raccoon</span>
                </label>
                <button wire:click="performSearch" class="btn btn-circle btn-sm ring ring-gray-200 absolute top-[4px] right-1 text-[10px] hover:btn-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                </button>
            </div>

        </div>

        <center class="text-[2.4rem] font-semibold">Explore Stories</center>

        @if (count($filteredStories))
            <section class="gap-3 flex md:px-56 sm:px-2 flex-col">
                @foreach ($filteredStories as $story)
                    <div class="story-card border-b-2">
                        <h2 class="text-xl mb-3 font-semibold">{{ $story['title'] }}</h2>
                        <p class="mb-3">{{ $story['content'] }}</p>
                    </div>
                @endforeach
            </section>
        @else
            <p>No stories found</p>
        @endif
    </section>

</div>
