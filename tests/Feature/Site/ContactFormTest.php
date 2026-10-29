<?php

namespace Tests\Feature\Site;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Setting;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(config('filesystems.media_disk'));
        $this->seed(ContentSeeder::class);
        Mail::fake();
    }

    /**
     * @return array<string, mixed>
     */
    private function validMessage(array $overrides = []): array
    {
        return [
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'message' => 'Saya ingin membuat website toko online.',
            ...$overrides,
        ];
    }

    public function test_a_message_is_stored_and_emailed(): void
    {
        $service = Service::query()->first();

        $this->from('/kontak')
            ->post('/kontak', $this->validMessage(['service_id' => $service->id]))
            ->assertRedirect('/kontak')
            ->assertSessionHas('success', 'Pesan terkirim! Saya akan segera membalas.');

        $message = ContactMessage::sole();
        $this->assertSame('Budi', $message->name);
        $this->assertSame('id', $message->locale);
        $this->assertTrue($message->service->is($service));

        Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail) use ($message): bool {
            return $mail->hasTo(Setting::get('contact.notification_email'))
                && $mail->hasReplyTo('budi@example.com')
                && $mail->contactMessage->is($message);
        });
    }

    public function test_messages_sent_from_the_english_page_remember_the_language(): void
    {
        $this->from('/en/contact')
            ->post('/en/contact', $this->validMessage())
            ->assertSessionHas('success', 'Message sent! I will get back to you soon.');

        $this->assertSame('en', ContactMessage::sole()->locale);
    }

    public function test_invalid_messages_are_rejected_in_indonesian(): void
    {
        $this->from('/kontak')
            ->post('/kontak', $this->validMessage(['email' => 'bukan-email', 'message' => 'pendek']))
            ->assertRedirect('/kontak')
            ->assertSessionHasErrors([
                'email' => 'Email harus berupa alamat email yang valid.',
                'message' => 'Pesan minimal 10 karakter.',
            ]);

        $this->assertSame(0, ContactMessage::count());
        Mail::assertNothingSent();
    }

    public function test_bots_filling_the_honeypot_are_rejected(): void
    {
        $this->from('/kontak')
            ->post('/kontak', $this->validMessage(['website' => 'https://spam.example']))
            ->assertSessionHasErrors('website');

        $this->assertSame(0, ContactMessage::count());
    }

    public function test_the_message_is_kept_when_the_email_cannot_be_sent(): void
    {
        Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP is down'));

        $this->from('/kontak')
            ->post('/kontak', $this->validMessage())
            ->assertRedirect('/kontak')
            ->assertSessionHas('success');

        $this->assertSame(1, ContactMessage::count());
    }

    public function test_the_form_is_rate_limited(): void
    {
        foreach (range(1, 5) as $attempt) {
            $this->from('/kontak')->post('/kontak', $this->validMessage())->assertRedirect();
        }

        $this->from('/kontak')->post('/kontak', $this->validMessage())->assertTooManyRequests();
    }
}
