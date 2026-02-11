<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Memorial;
use App\Models\VirtualGift;
use Illuminate\View\View;
use Livewire\Component;

class VirtualGiftPanel extends Component
{
    public Memorial $memorial;
    public string $selectedType = 'candle';
    public string $message = '';
    public bool $showForm = false;

    protected array $giftTypes = [
        'candle' => ['emoji' => "\u{1F56F}", 'label' => 'Candle'],
        'flower' => ['emoji' => "\u{1F339}", 'label' => 'Flower'],
        'tree' => ['emoji' => "\u{1F333}", 'label' => 'Tree'],
        'wreath' => ['emoji' => "\u{1FAB7}", 'label' => 'Wreath'],
        'star' => ['emoji' => "\u{2B50}", 'label' => 'Star'],
    ];

    public function mount(Memorial $memorial): void
    {
        $this->memorial = $memorial;
    }

    public function placeGift(): void
    {
        $this->validate([
            'selectedType' => ['required', 'in:candle,flower,tree,wreath,star'],
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        VirtualGift::create([
            'memorial_id' => $this->memorial->id,
            'user_id' => auth()->id(),
            'type' => $this->selectedType,
            'message' => $this->message ?: null,
        ]);

        $this->reset(['message', 'showForm']);
        $this->memorial->refresh();
        session()->flash('gift-success', __('Your gift has been placed.'));
    }

    public function render(): View
    {
        $giftCounts = [];
        foreach ($this->giftTypes as $type => $info) {
            $giftCounts[$type] = [
                ...$info,
                'count' => $this->memorial->virtualGifts()->where('type', $type)->count(),
            ];
        }

        return view('livewire.virtual-gift-panel', [
            'giftCounts' => $giftCounts,
        ]);
    }
}
