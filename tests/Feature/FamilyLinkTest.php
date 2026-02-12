<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\FamilyTreeEditor;
use App\Models\FamilyLink;
use App\Models\Memorial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FamilyLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_family_link(): void
    {
        $user = User::factory()->create();
        $memorial1 = Memorial::factory()->for($user)->create();
        $memorial2 = Memorial::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(FamilyTreeEditor::class, ['memorial' => $memorial1])
            ->set('showForm', true)
            ->set('search', $memorial2->first_name)
            ->set('selectedMemorialId', $memorial2->id)
            ->set('relationship', 'spouse')
            ->call('addLink')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('family_links', [
            'memorial_id' => $memorial1->id,
            'related_memorial_id' => $memorial2->id,
            'relationship' => 'spouse',
        ]);
    }

    public function test_reciprocal_link_created(): void
    {
        $user = User::factory()->create();
        $memorial1 = Memorial::factory()->for($user)->create();
        $memorial2 = Memorial::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(FamilyTreeEditor::class, ['memorial' => $memorial1])
            ->set('showForm', true)
            ->set('selectedMemorialId', $memorial2->id)
            ->set('relationship', 'parent')
            ->call('addLink');

        $this->assertDatabaseHas('family_links', [
            'memorial_id' => $memorial2->id,
            'related_memorial_id' => $memorial1->id,
            'relationship' => 'child',
        ]);
    }

    public function test_removing_link_removes_reciprocal(): void
    {
        $user = User::factory()->create();
        $memorial1 = Memorial::factory()->for($user)->create();
        $memorial2 = Memorial::factory()->for($user)->create();

        $link = FamilyLink::create([
            'memorial_id' => $memorial1->id,
            'related_memorial_id' => $memorial2->id,
            'relationship' => 'sibling',
        ]);
        FamilyLink::create([
            'memorial_id' => $memorial2->id,
            'related_memorial_id' => $memorial1->id,
            'relationship' => 'sibling',
        ]);

        Livewire::actingAs($user)
            ->test(FamilyTreeEditor::class, ['memorial' => $memorial1])
            ->call('removeLink', $link->id);

        $this->assertDatabaseMissing('family_links', [
            'memorial_id' => $memorial1->id,
            'related_memorial_id' => $memorial2->id,
        ]);
        $this->assertDatabaseMissing('family_links', [
            'memorial_id' => $memorial2->id,
            'related_memorial_id' => $memorial1->id,
        ]);
    }

    public function test_cannot_link_memorial_to_itself(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(FamilyTreeEditor::class, ['memorial' => $memorial])
            ->set('showForm', true)
            ->set('selectedMemorialId', $memorial->id)
            ->set('relationship', 'sibling')
            ->call('addLink')
            ->assertHasErrors('selectedMemorialId');
    }

    public function test_cannot_create_duplicate_link(): void
    {
        $user = User::factory()->create();
        $memorial1 = Memorial::factory()->for($user)->create();
        $memorial2 = Memorial::factory()->for($user)->create();

        FamilyLink::create([
            'memorial_id' => $memorial1->id,
            'related_memorial_id' => $memorial2->id,
            'relationship' => 'spouse',
        ]);

        Livewire::actingAs($user)
            ->test(FamilyTreeEditor::class, ['memorial' => $memorial1])
            ->set('showForm', true)
            ->set('selectedMemorialId', $memorial2->id)
            ->set('relationship', 'sibling')
            ->call('addLink')
            ->assertHasErrors('selectedMemorialId');
    }

    public function test_family_links_display_on_public_memorial(): void
    {
        $user = User::factory()->create();
        $memorial1 = Memorial::factory()->for($user)->public()->create();
        $memorial2 = Memorial::factory()->for($user)->public()->create([
            'first_name' => 'RelatedPerson',
        ]);

        FamilyLink::create([
            'memorial_id' => $memorial1->id,
            'related_memorial_id' => $memorial2->id,
            'relationship' => 'spouse',
        ]);

        $response = $this->get("/{$memorial1->slug}");

        $response->assertStatus(200);
        $response->assertSee('RelatedPerson');
        $response->assertSee(__('Family Connections'));
    }
}
