<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Memorial;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class SearchMemorials extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 12;

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->perPage = 12;
    }

    public function loadMore(): void
    {
        $this->perPage += 12;
    }

    public function render(): View
    {
        $query = Memorial::publiclyVisible()
            ->with('user')
            ->withCount(['virtualGifts', 'approvedTributes']);

        if ($this->search) {
            $searchIds = Memorial::search($this->search)->keys();
            $query->whereIn('id', $searchIds);
        }

        $memorials = $query->latest()->paginate($this->perPage);

        return view('livewire.search-memorials', [
            'memorials' => $memorials,
        ]);
    }
}
