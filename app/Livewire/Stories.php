<?php

namespace App\Livewire;
use App\Models\Story;
use Illuminate\View\View;
use Livewire\Component;

class Stories extends Component
{
    public string $search = '';
    public function render()
    {
        $filteredStories = Story::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.stories', ['filteredStories' => $filteredStories]);
    }

}
