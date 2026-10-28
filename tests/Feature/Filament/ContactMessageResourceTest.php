<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\ContactMessages\Pages\ListContactMessages;
use App\Filament\Resources\ContactMessages\Pages\ViewContactMessage;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactMessageResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsAdmin();
    }

    public function test_opening_a_message_marks_it_as_read(): void
    {
        $message = ContactMessage::factory()->create();

        Livewire::test(ViewContactMessage::class, ['record' => $message->getRouteKey()])
            ->assertOk()
            ->assertSee($message->email);

        $this->assertNotNull($message->fresh()->read_at);
    }

    public function test_the_navigation_badge_counts_unread_messages(): void
    {
        ContactMessage::factory()->count(2)->create();
        ContactMessage::factory()->create(['read_at' => now()]);

        $this->assertSame('2', ContactMessageResource::getNavigationBadge());
    }

    public function test_messages_can_be_marked_as_read_in_bulk(): void
    {
        $messages = ContactMessage::factory()->count(2)->create();

        Livewire::test(ListContactMessages::class)
            ->callTableBulkAction('markAsRead', $messages);

        $this->assertSame(0, ContactMessage::unread()->count());
    }

    public function test_messages_cannot_be_created_from_the_cms(): void
    {
        $this->assertFalse(ContactMessageResource::canCreate());
        $this->assertFalse(ContactMessageResource::hasPage('create'));
    }
}
