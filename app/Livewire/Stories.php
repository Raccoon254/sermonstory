<?php

namespace App\Livewire;
use App\Models\Story;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Stories extends Component
{
    public string $search = '';
    use WithPagination;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }


    public function performSearch(): void
    {
        $this->resetPage();
    }


    public function render(): View
    {
        return view('livewire.stories', ['filteredStories' => Story::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
                ->orWhere('moral_lesson', 'like', '%' . $this->search . '%')
            ->orWhereHas('categoryTags', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('scriptures', function ($query) {
                $query->where('content', 'like', '%' . $this->search . '%');
            })
            ->paginate(10)]);
    }

}
