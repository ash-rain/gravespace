<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Memorial;
use App\Models\Tribute;
use App\Notifications\TributeReceived;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class TributeWall extends Component
{
    use WithPagination;

    public Memorial $memorial;
    public string $body = '';
    public string $authorName = '';
    public string $authorEmail = '';
    public bool $showForm = false;

    public function mount(Memorial $memorial): void
    {
        $this->memorial = $memorial;
    }

    public function submitTribute(): void
    {
        $rules = [
            'body' => ['required', 'string', 'max:5000'],
        ];

        if (! auth()->check()) {
            $rules['authorName'] = ['required', 'string', 'max:255'];
            $rules['authorEmail'] = ['nullable', 'email', 'max:255'];
        }

        $this->validate($rules);

        $tribute = Tribute::create([
            'memorial_id' => $this->memorial->id,
            'user_id' => auth()->id(),
            'author_name' => auth()->check() ? auth()->user()->name : $this->authorName,
            'author_email' => auth()->check() ? auth()->user()->email : $this->authorEmail,
            'body' => $this->body,
            'is_approved' => false,
        ]);

        $this->memorial->user->notify(new TributeReceived($tribute));

        $this->reset(['body', 'authorName', 'authorEmail', 'showForm']);
        session()->flash('tribute-success', __('Your tribute has been submitted and is awaiting approval.'));
    }

    public function render(): View
    {
        return view('livewire.tribute-wall', [
            'tributes' => $this->memorial->approvedTributes()->paginate(10),
        ]);
    }
}
