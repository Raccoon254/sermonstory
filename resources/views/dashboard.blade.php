<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="welcome">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="overflow-hidden">
                <h1 class="text-2xl font-semibold">
                    Welcome to Sermon Stories
                </h1>
            </div>
        </div>
    </div>

    <div class="py-12">



        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-gray-50 overflow-hidden shadow-sm">
                <div class="p-6 flex flex-col text-gray-900">
                    Select a story category to get started. Get our carefully curated stories written by our authors and bring your sermon audience to life.
                    <div class="flex gap-3 my-3 actions">
                        <a href="{{ route('stories.index') }}">
                            <button class="btn btn-md btn-primary normal-case ring">
                                <i class="fa-solid fa-pen-nib"></i> Author Stories
                            </button>
                        </a>
                        <a href="{{ route('gptstories.index') }}">
                            <button class="btn btn-md btn-outline ring normal-case ring-blue-500">
                                <i class="fa-solid fa-mountain"></i> Gpt Stories
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-gray-50 overflow-hidden shadow-sm">
                <div class="p-6 flex flex-col text-gray-900">
                    By using our AI powered story generator, you can create a story in seconds. Simply enter a title and select up to 3 categories and we'll do the rest.

                    <a href="{{ route('generate.story') }}" class="mt-4 inline-block font-bold py-2 rounded">
                        <button class="btn btn-md btn-outline normal-case ring ring-blue-500">
                            <i class="fa-solid fa-forward"></i> Generate a Story
                        </button>
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
