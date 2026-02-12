<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Invitation;
use App\Models\Memorial;
use App\Notifications\MemorialInvitation as MemorialInvitationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Livewire\Component;

class InvitationManager extends Component
{
    public Memorial $memorial;

    public string $email = '';

    public string $role = 'viewer';

    public bool $showForm = false;

    public function mount(Memorial $memorial): void
    {
        $this->memorial = $memorial;
    }

    public function sendInvitation(): void
    {
        $this->validate([
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', 'in:viewer,editor'],
        ]);

        $existing = Invitation::where('memorial_id', $this->memorial->id)
            ->where('email', $this->email)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->first();

        if ($existing) {
            $this->addError('email', __('An invitation has already been sent to this email.'));

            return;
        }

        $token = Invitation::generateToken();

        $invitation = Invitation::create([
            'memorial_id' => $this->memorial->id,
            'invited_by' => auth()->id(),
            'email' => $this->email,
            'role' => $this->role,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);

        Notification::route('mail', $this->email)
            ->notify(new MemorialInvitationNotification($this->memorial, auth()->user(), $this->role, $token));

        $this->reset(['email', 'role', 'showForm']);
        $this->role = 'viewer';
    }

    public function revokeInvitation(int $invitationId): void
    {
        Invitation::where('id', $invitationId)
            ->where('memorial_id', $this->memorial->id)
            ->delete();
    }

    public function removeManager(int $userId): void
    {
        if ($userId === $this->memorial->user_id) {
            return;
        }

        $this->memorial->managers()->detach($userId);
    }

    public function render(): View
    {
        return view('livewire.invitation-manager', [
            'managers' => $this->memorial->managers()->get(),
            'pendingInvitations' => Invitation::where('memorial_id', $this->memorial->id)
                ->pending()
                ->latest()
                ->get(),
        ]);
    }
}
