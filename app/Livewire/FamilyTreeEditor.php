<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\FamilyLink;
use App\Models\Memorial;
use Illuminate\View\View;
use Livewire\Component;

class FamilyTreeEditor extends Component
{
    public Memorial $memorial;

    public ?int $selectedMemorialId = null;

    public string $relationship = 'spouse';

    public string $search = '';

    public bool $showForm = false;

    /** @var array<string, string> */
    private static array $reciprocalMap = [
        'spouse' => 'spouse',
        'parent' => 'child',
        'child' => 'parent',
        'sibling' => 'sibling',
        'grandparent' => 'grandchild',
        'grandchild' => 'grandparent',
        'aunt' => 'niece',
        'uncle' => 'nephew',
        'niece' => 'aunt',
        'nephew' => 'uncle',
        'cousin' => 'cousin',
    ];

    public function mount(Memorial $memorial): void
    {
        $this->memorial = $memorial;
    }

    public function addLink(): void
    {
        $this->validate([
            'selectedMemorialId' => ['required', 'integer', 'exists:memorials,id'],
            'relationship' => ['required', 'string', 'max:50'],
        ]);

        if ($this->selectedMemorialId === $this->memorial->id) {
            $this->addError('selectedMemorialId', __('Cannot link a memorial to itself.'));

            return;
        }

        $existing = FamilyLink::where('memorial_id', $this->memorial->id)
            ->where('related_memorial_id', $this->selectedMemorialId)
            ->exists();

        if ($existing) {
            $this->addError('selectedMemorialId', __('This connection already exists.'));

            return;
        }

        FamilyLink::create([
            'memorial_id' => $this->memorial->id,
            'related_memorial_id' => $this->selectedMemorialId,
            'relationship' => $this->relationship,
        ]);

        $reciprocal = self::$reciprocalMap[$this->relationship] ?? $this->relationship;
        FamilyLink::create([
            'memorial_id' => $this->selectedMemorialId,
            'related_memorial_id' => $this->memorial->id,
            'relationship' => $reciprocal,
        ]);

        $this->reset(['selectedMemorialId', 'relationship', 'search', 'showForm']);
        $this->relationship = 'spouse';
        $this->memorial->refresh();
    }

    public function removeLink(int $linkId): void
    {
        $link = FamilyLink::where('id', $linkId)
            ->where('memorial_id', $this->memorial->id)
            ->firstOrFail();

        FamilyLink::where('memorial_id', $link->related_memorial_id)
            ->where('related_memorial_id', $this->memorial->id)
            ->delete();

        $link->delete();
        $this->memorial->refresh();
    }

    public function render(): View
    {
        $availableMemorials = collect();

        if (strlen($this->search) >= 2) {
            $linkedIds = $this->memorial->familyLinks()->pluck('related_memorial_id')->toArray();
            $linkedIds[] = $this->memorial->id;

            $availableMemorials = Memorial::where('user_id', $this->memorial->user_id)
                ->whereNotIn('id', $linkedIds)
                ->where(function ($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                })
                ->limit(10)
                ->get();
        }

        return view('livewire.family-tree-editor', [
            'links' => $this->memorial->familyLinks()->with('relatedMemorial')->get(),
            'availableMemorials' => $availableMemorials,
        ]);
    }
}
