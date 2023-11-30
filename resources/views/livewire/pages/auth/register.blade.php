<?php

use App\Models\User;
use App\Models\Story;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?int $story_id = null; // Add this line

    public function mount($story_id = null): void
    {
        $story_id = request()->query('story_id');
        $this->story_id = $story_id;
    }

    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        auth()->login($user);

        // Redirect to the story if story_id is set, else redirect to home
        if ($this->story_id) {
            //dd($this->story_id);
            $story = Story::find($this->story_id);
            return redirect()->route('stories.show', $story);
        } else {
            return redirect(RouteServiceProvider::HOME);
        }
    }

}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required
                          autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
                          autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <section class="flex gap-3">
            <!--Church Name -->
            <div class="mt-4">
                <x-input-label for="church_name" :value="__('Church Name')"/>
                <x-text-input wire:model="church_name" id="church_name" class="block mt-1 w-full" type="text"
                              name="church_name" required autofocus autocomplete="church_name"/>
                <x-input-error :messages="$errors->get('church_name')" class="mt-2"/>
            </div>

            <!--Phone Number -->
            <div class="mt-4">
                <x-input-label for="phone_number" :value="__('Phone Number')"/>
                <x-text-input wire:model="phone_number" id="phone_number" class="block mt-1 w-full" type="text"
                              name="phone_number" required autofocus autocomplete="phone_number"/>
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2"/>
            </div>
        </section>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <button class="btn btn-warning ring ring-blue-600 ring-inset ml-4">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
