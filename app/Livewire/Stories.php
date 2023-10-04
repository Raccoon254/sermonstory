<?php

namespace App\Livewire;
use Illuminate\View\View;
use Livewire\Component;

class Stories extends Component
{
    public string $search = '';
    public array $stories = [
        [
            'title' => 'The Midday Chase',
            'content' => 'Under the shroud of darkness, two figures raced against time, moving through the labyrinthine alleyways of the old city...'
        ],
        [
            'title' => 'Lost in Time',
            'content' => 'Samantha stumbled upon an ancient clock in her grandmother\'s attic, not knowing it had the power to transport her to a different era...'
        ],
        [
            'title' => 'The Silent Symphony',
            'content' => 'In a world where sound ceased to exist, Clara, a talented violinist, discovers a mysterious tune that might just bring music back...'
        ],
        [
            'title' => 'Whispers of the Forest',
            'content' => 'The trees in Eldenwood have secrets, and young Eli is determined to uncover them, guided only by the soft whispers he hears at night...'
        ],
        [
            'title' => 'The Last Space Odyssey',
            'content' => 'Earth\'s last spaceship, Artemis, embarks on a journey to find humanity\'s new home, but the mysteries of the universe prove to be more challenging than they anticipated...'
        ],
        [
            'title' => 'Beneath the Mask',
            'content' => 'In a city of masked inhabitants, Lina is the only one without a mask. Determined to find hers, she uncovers secrets darker than she could\'ve imagined...'
        ]
    ];

    public function updatedSearch(): void
    {
        $this->emitSelf('render');
    }

    public function render(): View
    {
        $filteredStories = collect($this->stories)->filter(function($story) {
            return str_contains(strtolower($story['title']), strtolower($this->search)) ||
                str_contains(strtolower($story['content']), strtolower($this->search));
        })->all();

        return view('livewire.stories', ['filteredStories' => $filteredStories]);
    }
}
