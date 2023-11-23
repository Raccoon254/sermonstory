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

            <div class="form-control w-full">
                <div class="form-control mb-3">
                    <label class="form-label">Scriptures</label>
                    <div id="scripture-container">
                        <!-- Initial scripture input -->
                        <div class="mb-2 flex scripture-field">
                            <input type="text" name="scriptures[]" class="w-full form-control">
                            <span class="btn rounded-[0px] btn-warning" onclick="addScriptureField()">Add</span>
                        </div>
                        <script>
                            function addScriptureField() {
                                const container = document.getElementById('scripture-container');
                                const newField = document.createElement('div');
                                newField.classList.add('mb-2', 'flex', 'scripture-field');
                                newField.innerHTML = `
        <input type="text" name="scriptures[]" class="w-full form-control">
        <span class="btn rounded-[0px] bg-red-600" onclick="removeScriptureField(this)">DEL</span>
    `;

                                container.appendChild(newField);
                            }

                            function removeScriptureField(element) {
                                element.parentElement.remove();
                            }

                        </script>
                    </div>
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
