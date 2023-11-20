<?php

use function Livewire\Volt\{state};
use Livewire\Volt\Component;
use App\Models\Story;
use Livewire\WithPagination;

new class extends Component
{
    public string $search = '';
    public $filteredStories;
    use WithPagination;

    public function mount(): void
    {
        $this->filteredStories = Story::paginate(10);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function performSearch(): void
    {
        $this->resetPage();
        $this->filteredStories = Story::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->orWhere('moral_lesson', 'like', '%' . $this->search . '%')
            ->orWhereHas('categoryTags', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('scriptures', function ($query) {
                $query->where('content', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }
}
?>

<div>

</div>
