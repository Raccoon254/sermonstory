<div>
    <section>

        <center class="text-[2.4rem] my-2 font-semibold">Explore Stories</center>
        @if (count($filteredStories))
            <section class="gap-3 flex md:px-20 sm:px-2 flex-col">

                <div class="w-full my-2">
                    <div class="w-full relative">
                        <label class="relative">
                            <input class="h-10 w-full input-bordered" wire:model="search" type="text" placeholder="Search for stories">
                            <span class="absolute top-[-10px] left-[15px] text-[8px] text-gray-300">Powered by Raccoon254</span>
                        </label>
                        <button wire:click="performSearch" class="h-8 w-8 flex items-center justify-center border-l border-gray-950 absolute top-[4px] right-1 text-[15px] hover:text-[20px] hover:text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                        </button>
                    </div>

                </div>

                @foreach ($filteredStories as $story)
                    <div class="story-card border-b-2">
                        <h2 class="text-xl mb-3 font-semibold">{{ $story['title'] }}</h2>
                        <p class="mb-3">{{ $story['content'] }}</p>

                        <div class="flex justify-end gap-2 mb-3">

                            <div class="flex tooltip gap-3 mb-3">
                                <a href="{{ route('stories.show', $story) }}" class="btn ring ring-inset">
                                    View Story
                                </a>
                            </div>

                        @if(auth()->user() && Gate::allows('manage'))

                                <div data-tip="Edit Story" class="flex tooltip gap-3 mb-3">
                                    <a href="{{ route('stories.edit', $story) }}" class="btn ring ring-inset">
                                        <i class="fa-solid fa-pen-nib"></i>
                                    </a>
                                </div>

                                <form data-tip="Delete Story" action="{{ route('stories.destroy', $story) }}" method="POST" class="d-inline tooltip">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn ring ring-inset ring-orange-600">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                        @endif

                        </div>



                        @php
                            $colors = ['red', 'blue', 'green', 'purple', 'pink', 'indigo', 'gray', 'yellow', 'orange', 'teal', 'cyan', 'fuchsia', 'lime', 'lightBlue', 'emerald', 'rose', 'violet', 'amber', 'sky', 'orange', 'indigo', 'pink', 'red', 'blue', 'green', 'purple', 'pink', 'indigo', 'gray', 'orange', 'teal', 'cyan', 'fuchsia', 'lime', 'lightBlue', 'emerald', 'rose', 'violet', 'amber', 'sky', 'orange', 'indigo', 'pink', 'red', 'blue', 'green', 'purple', 'pink', 'indigo', 'gray', 'yellow', 'orange', 'teal', 'cyan', 'fuchsia', 'lightBlue', 'emerald', 'rose', 'violet', 'amber', 'sky', 'orange', 'indigo', 'pink', 'red', 'blue', 'green', 'purple', 'pink', 'indigo', 'gray', 'yellow', 'orange', 'teal', 'cyan', 'fuchsia', 'lime', 'lightBlue', 'emerald', 'rose', 'violet', 'amber', 'sky', 'orange', 'indigo', 'pink'];
                        @endphp
                       <section class="flex text-xs gap-4 mb-3">
                           <!--Verses-->
                           <div class="flex align-middle items-center flex-wrap gap-1 mb-2">
                               @foreach ($story->scriptures as $scripture)
                                   @php
                                       $randomColor = $colors[array_rand($colors)];
                                   @endphp
                                   <i style="color: {{$randomColor}}" class="fa-solid fa-bookmark"></i> <span class="tag mr-3">{{ $scripture->content }}</span>
                               @endforeach
                           </div>

                           <!--tags-->
                           <div class="flex align-middle items-center flex-wrap gap-1 mb-2">
                               @foreach ($story->categoryTags as $tag)
                                   @php
                                       $randomColor = $colors[array_rand($colors)];
                                   @endphp
                                   <i style="color: {{$randomColor}}" class="fa-solid fa-tag"></i> <span class="tag mr-3">{{ $tag->name }}</span>
                               @endforeach
                           </div>
                       </section>

                    </div>
                @endforeach

                <div class="w-full custom flex justify-between">
                    {{ $filteredStories->links() }}
                </div>
            </section>
        @else
            <div class="h-[50vh] flex justify-center items-center">
                <center>No stories found</center>
            </div>
        @endif

    </section>

</div>
