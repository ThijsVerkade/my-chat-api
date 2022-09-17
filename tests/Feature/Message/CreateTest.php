<?php

namespace Tests\Feature\Message;

use App\Modules\Messages\Message;
use App\Modules\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }

    public function testCreateMessageWillReturnHttpNotFound(): void
    {
        $sender = User::factory(1)->create()->first();
        $recipient = User::factory(1)->create()->first();
        $message = $this->faker->text();

        $response = $this->post(
            route('api.message.post.create'),
            [
                'sender_uuid' => $sender->uuid,
                'recipient_uuid' => $recipient->uuid,
                'message' => $message,
            ]
        );

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $createdMessage = Message::latest()->first();
        self::assertEquals($sender->id, $createdMessage->sender_id);
        self::assertEquals($recipient->id, $createdMessage->recipient_id);
        self::assertEquals($message, $createdMessage->message);
    }

    public function testCreateMessageWithInvalidSenderUuid(): void
    {
        $senderUuid = $this->faker->uuid();
        $recipient = User::factory(1)->create()->first();
        $message = $this->faker->text();

        $response = $this->post(
            route('api.message.post.create'),
            [
                'sender_uuid' => $senderUuid,
                'recipient_uuid' => $recipient->uuid,
                'message' => $message,
            ]
        );

        $response->assertStatus(Response::HTTP_FOUND);
    }


    public function testCreateMessageWithInvalidRecipientUuid(): void
    {
        $sender = User::factory(1)->create()->first();
        $recipientUuid = $this->faker->uuid();
        $message = $this->faker->text();

        $response = $this->post(
            route('api.message.post.create'),
            [
                'sender_uuid' => $sender->uuid,
                'recipient_uuid' => $recipientUuid,
                'message' => $message,
            ]
        );

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
