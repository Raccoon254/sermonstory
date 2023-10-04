<div>
    <section>
        <input
            type="text"
            wire:model="search"
            placeholder="Search for stories..."
            class="search-box input input-bordered w-full"
        />

        <h1 class="font-semibold">Explore Stories</h1>

        @if (count($filteredStories))
            @foreach ($filteredStories as $story)
                <div class="story-card border-b-2">
                    <h2 class="text-xl font-semibold">{{ $story['title'] }}</h2>
                    <p>{{ $story['content'] }}</p>
                </div>
            @endforeach
        @else
            <p>No stories found</p>
        @endif
    </section>

</div>
