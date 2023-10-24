<x-app-layout>
    <h1 class="m-4">Create Story</h1>
    <section class="w-full flex justify-center items-center">
        <form class="w-full max-w-sm" action="{{ route('stories.store') }}" method="POST">
            @csrf
            <div class="form-control mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-control mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" required></textarea>
            </div>
            <div class="form-control mb-3">
                <label class="form-label">Moral Lesson</label>
                <input type="text" name="moral_lesson" class="form-control">
            </div>

            <!--Conclusions-->
            <div class="form-control mb3">
                <label for="conclusion" class="form-label Conclusions">Conclusion</label>
                <textarea id="conclusion" name="conclusion" class="form-control" required></textarea>
            </div>

            <div class="form-control w-full" x-data="{ scriptures: [{content: ''}] }">

                <div class="form-control mb-3">
                    <label class="form-label">Scriptures</label>

                    <template x-for="(scripture, index) in scriptures" :key="index">
                        <div class="mb-2 flex">
                            <input x-model="scripture.content" type="text" name="scriptures[]" class="w-full form-control">
                            <span class="btn rounded-[0px] btn-warning" x-show="index === scriptures.length - 1" @click="scriptures.push({content: ''})">Add</span>
                            <span class="btn rounded-[0px] bg-red-600" x-show="scriptures.length > 1" @click="scriptures.splice(index, 1)">DEL</span>
                        </div>
                    </template>

                </div>

            </div>

            <div class="form-control">
                <label class="form-label mb-3">Category Tags</label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 text-[10px] gap-4 mb-3">
                    @foreach($categoryTags as $tag)
                        <div class="flex items-center">
                            <input class="form-check-input mr-2" type="checkbox" name="category_tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}">
                            <label class="form-check-label" for="tag-{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center m-4 justify-center">
                <button type="submit" class="btn btn-outline ring ring-inset">Create Story</button>
            </div>
        </form>
    </section>
</x-app-layout>
