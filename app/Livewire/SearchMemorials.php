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

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $query = Memorial::publiclyVisible()
            ->with('user')
            ->withCount(['virtualGifts', 'approvedTributes']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%")
                  ->orWhere('obituary', 'like', "%{$this->search}%");
            });
        }

        return view('livewire.search-memorials', [
            'memorials' => $query->latest()->paginate(12),
        ]);
    }
}
