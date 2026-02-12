<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\InvitationManager;
use App\Models\Invitation;
use App\Models\Memorial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_send_invitation(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(InvitationManager::class, ['memorial' => $memorial])
            ->set('showForm', true)
            ->set('email', 'friend@example.com')
            ->set('role', 'editor')
            ->call('sendInvitation')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('invitations', [
            'memorial_id' => $memorial->id,
            'email' => 'friend@example.com',
            'role' => 'editor',
            'invited_by' => $user->id,
        ]);
    }

    public function test_cannot_send_duplicate_invitation(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        Invitation::factory()->pending()->create([
            'memorial_id' => $memorial->id,
            'invited_by' => $user->id,
            'email' => 'friend@example.com',
        ]);

        Livewire::actingAs($user)
            ->test(InvitationManager::class, ['memorial' => $memorial])
            ->set('showForm', true)
            ->set('email', 'friend@example.com')
            ->set('role', 'viewer')
            ->call('sendInvitation')
            ->assertHasErrors('email');
    }

    public function test_owner_can_revoke_invitation(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $invitation = Invitation::factory()->pending()->create([
            'memorial_id' => $memorial->id,
            'invited_by' => $user->id,
        ]);

        Livewire::actingAs($user)
            ->test(InvitationManager::class, ['memorial' => $memorial])
            ->call('revokeInvitation', $invitation->id);

        $this->assertDatabaseMissing('invitations', ['id' => $invitation->id]);
    }

    public function test_user_can_accept_invitation(): void
    {
        $owner = User::factory()->create();
        $invitee = User::factory()->create();
        $memorial = Memorial::factory()->for($owner)->create();

        $invitation = Invitation::factory()->pending()->create([
            'memorial_id' => $memorial->id,
            'invited_by' => $owner->id,
            'email' => $invitee->email,
            'role' => 'editor',
        ]);

        $response = $this->actingAs($invitee)->get(route('invitation.accept', $invitation->token));

        $response->assertRedirect(route('dashboard.memorials.edit', $memorial));
        $this->assertDatabaseHas('invitations', [
            'id' => $invitation->id,
            'accepted_at' => now()->toDateTimeString(),
        ]);
        $this->assertTrue($memorial->managers()->where('user_id', $invitee->id)->exists());
    }

    public function test_expired_invitation_cannot_be_accepted(): void
    {
        $owner = User::factory()->create();
        $invitee = User::factory()->create();
        $memorial = Memorial::factory()->for($owner)->create();

        $invitation = Invitation::factory()->expired()->create([
            'memorial_id' => $memorial->id,
            'invited_by' => $owner->id,
            'email' => $invitee->email,
        ]);

        $response = $this->actingAs($invitee)->get(route('invitation.accept', $invitation->token));

        $response->assertRedirect(route('dashboard.index'));
        $response->assertSessionHas('error');
    }

    public function test_guest_cannot_accept_invitation(): void
    {
        $invitation = Invitation::factory()->pending()->create();

        $response = $this->get(route('invitation.accept', $invitation->token));

        $response->assertRedirect('/login');
    }

    public function test_invalid_token_returns_404(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('invitation.accept', 'invalid-token-123'));

        $response->assertStatus(404);
    }

    public function test_owner_can_remove_manager(): void
    {
        $owner = User::factory()->create();
        $manager = User::factory()->create();
        $memorial = Memorial::factory()->for($owner)->create();
        $memorial->managers()->attach($manager->id, ['role' => 'editor']);

        Livewire::actingAs($owner)
            ->test(InvitationManager::class, ['memorial' => $memorial])
            ->call('removeManager', $manager->id);

        $this->assertFalse($memorial->managers()->where('user_id', $manager->id)->exists());
    }

    public function test_cannot_remove_memorial_owner(): void
    {
        $owner = User::factory()->create();
        $memorial = Memorial::factory()->for($owner)->create();
        $memorial->managers()->attach($owner->id, ['role' => 'owner']);

        Livewire::actingAs($owner)
            ->test(InvitationManager::class, ['memorial' => $memorial])
            ->call('removeManager', $owner->id);

        $this->assertTrue($memorial->managers()->where('user_id', $owner->id)->exists());
    }
}
