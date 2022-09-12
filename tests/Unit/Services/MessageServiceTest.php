<?php

namespace Tests\Unit\Services;

use App\Exceptions\Message\InvalidMessage;
use App\Models\Message;
use App\Models\User;
use App\Services\MessageService;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class MessageServiceTest extends TestCase
{
    public function testCreateMessageSuccessfully(): void
    {
        $messageModel = $this->createMock(Message::class);
        $userModel = $this->createMock(User::class);

        $service = new MessageService($messageModel, $userModel);

        $sender = new User();
        $sender->id = 1;
        $sender->uuid = '1153409a-9db2-4fb3-9a4f-0a0927854077';

        $recipient = new User();
        $recipient->id = 2;
        $recipient->uuid = 'd1b66184-de05-4db6-915e-e1ace1fca24d';

        $message = 'test-message';

        $userModel->expects($this->exactly(2))
            ->method('findByUuid')
            ->withConsecutive([$sender['uuid']], [$recipient['uuid']])
            ->willReturnOnConsecutiveCalls($sender, $recipient);

        $messageModel->expects($this->once())
            ->method('create')
            ->with(
                $sender['id'],
                $recipient['id'],
                $message
            );

        $service->create(
            Uuid::fromString($sender['uuid']),
            Uuid::fromString($recipient['uuid']),
            $message
        );
    }

    public function testCreateMessageWithInvalidSenderUuidThrowException(): void
    {
        $messageModel = $this->createMock(Message::class);
        $userModel = $this->createMock(User::class);

        $service = new MessageService($messageModel, $userModel);

        $senderUuid = 'f0ea6a1f-5ea6-43ba-aa41-a9a6405ea44c';

        $recipient = new User();
        $recipient->uuid = 'b97508ca-69cd-4848-a06f-163da2ca5118';

        $message = 'test-message';

        $userModel->expects($this->once())
            ->method('findByUuid')
            ->with($senderUuid)
            ->willReturn(null);

        $this->expectException(InvalidMessage::class);

        $service->create(
            Uuid::fromString($senderUuid),
            Uuid::fromString($recipient['uuid']),
            $message
        );
    }

    public function testCreateMessageWithInvalidRecipientUuidThrowException(): void
    {
        $messageModel = $this->createMock(Message::class);
        $userModel = $this->createMock(User::class);

        $service = new MessageService($messageModel, $userModel);

        $sender = new User();
        $sender->uuid = '1153409a-9db2-4fb3-9a4f-0a0927854077';

        $recipientUuid = '0a854943-45fb-4afc-9c6e-1a2bd0791d41';

        $message = 'test-message';

        $userModel->expects($this->exactly(2))
            ->method('findByUuid')
            ->withConsecutive([$sender['uuid']], [$recipientUuid])
            ->willReturnOnConsecutiveCalls($sender, null);

        $this->expectException(InvalidMessage::class);

        $service->create(
            Uuid::fromString($sender['uuid']),
            Uuid::fromString($recipientUuid),
            $message
        );
    }
}
