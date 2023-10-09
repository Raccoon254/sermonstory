<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col text-gray-900">
                    {{ __("You're logged in!") }}
                    you can view stories here
                    <a href="{{ route('stories.index') }}" class="text-indigo-600 mt-2 inline-block">View Stories</a>
                </div>
            </div>
        </div>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col text-gray-900">
                    {{ __("Generate Stories using gpt4 api key") }}

                    <a href="{{ route('generate.story') }}" class="mt-4 inline-block font-bold py-2 rounded">
                        Generate Story
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
