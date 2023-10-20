<x-app-layout>
    <h1 class="m-4">Edit Story</h1>
    <section class="w-full flex justify-center items-center">
        <form class="w-full max-w-sm" action="{{ route('stories.update', $story) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3 form-control">
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ $story->title }}" class="form-control" required>
            </div>
            <div class="mb-3 form-control">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" required>{{ $story->content }}</textarea>
            </div>
            <div class="mb-3 form-control">
                <label class="form-label">Moral Lesson</label>
                <input type="text" name="moral_lesson" value="{{ $story->moral_lesson }}" class="form-control">
            </div>
            <div class="mb-3 form-control">
                <label class="form-label">Scriptures</label>
                @foreach($story->scriptures as $scripture)
                    <div class="mb-2 flex">
                        <input type="text" name="scriptures[]" value="{{ $scripture->content }}" class="w-full form-control">
                        <!-- You can also add "Add" and "DEL" buttons here if necessary -->
                    </div>
                @endforeach
            </div>

            <div class="mb-3 form-control">
                <label class="form-label mb-3">Category Tags</label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 text-[10px] gap-4 mb-3">
                    @foreach($categoryTags as $tag)
                        <div class="flex items-center">
                            <input class="form-check-input mr-2" type="checkbox" name="category_tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}" @if($story->categoryTags->contains($tag)) checked @endif>
                            <label class="form-check-label" for="tag-{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center m-4 justify-center">
                <button type="submit" class="btn btn-outline ring ring-inset">Update</button>
            </div>
        </form>
    </section>
</x-app-layout>
