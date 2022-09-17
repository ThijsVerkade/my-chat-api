<?php

namespace Tests\Unit\Modules\Messages\Services;

use App\Modules\Chats\Chat;
use App\Modules\Chats\Repositories\ChatRepository;
use App\Modules\Messages\Exceptions\MessageException;
use App\Modules\Messages\Repositories\MessageRepository;
use App\Modules\Messages\Services\CreateMessageService;
use App\Modules\Users\Repositories\UserRepository;
use App\Modules\Users\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateMessageServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateMessageSuccessfullyWithChatExisting(): void
    {
        $repository = $this->createMock(MessageRepository::class);
        $userRepository = $this->createMock(UserRepository::class);
        $chatRepository = $this->createMock(ChatRepository::class);

        $service = new CreateMessageService($repository, $userRepository, $chatRepository);

        $sender = new User([
            'id' => 1,
            'uuid' => 'f0ea6a1f-5ea6-43ba-aa41-a9a6405ea44c',
        ]);
        $recipient = new User([
            'id' => 2,
            'uuid' => 'b805e192-20e4-400b-a817-0c29f168c714',
        ]);
        $existingChat = new Chat([
            'id' => 1,
        ]);
        $message = 'this-is-a-random-text';

        $userRepository->expects($this->exactly(2))
            ->method('findByUuid')
            ->withConsecutive([$sender->uuid], [$recipient->uuid])
            ->willReturnOnConsecutiveCalls($sender, $recipient);

        $chatRepository->expects($this->once())
            ->method('findBySenderIdAndRecipientId')
            ->with($sender->id, $recipient->id)
            ->willReturn($existingChat);

        $repository->expects($this->once())
            ->method('create')
            ->with(
                $existingChat->id,
                $message,
            );

        $service->create(
            Uuid::fromString($sender->uuid),
            Uuid::fromString($recipient->uuid),
            $message
        );
    }

    public function testCreateMessageSuccessfullyWithoutChatExisting(): void
    {
        $repository = $this->createMock(MessageRepository::class);
        $userRepository = $this->createMock(UserRepository::class);
        $chatRepository = $this->createMock(ChatRepository::class);

        $service = new CreateMessageService($repository, $userRepository, $chatRepository);

        $sender = new User([
            'id' => 1,
            'uuid' => 'f0ea6a1f-5ea6-43ba-aa41-a9a6405ea44c',
        ]);
        $recipient = new User([
            'id' => 2,
            'uuid' => 'b805e192-20e4-400b-a817-0c29f168c714',
        ]);
        $newChat = new Chat([
            'id' => 1,
        ]);
        $message = 'this-is-a-random-text';

        $userRepository->expects($this->exactly(2))
            ->method('findByUuid')
            ->withConsecutive([$sender->uuid], [$recipient->uuid])
            ->willReturnOnConsecutiveCalls($sender, $recipient);

        $chatRepository->expects($this->once())
            ->method('findBySenderIdAndRecipientId')
            ->with($sender->id, $recipient->id)
            ->willReturn(null);

        $chatRepository->expects($this->once())
            ->method('create')
            ->with($sender->id, $recipient->id)
            ->willReturn($newChat);

        $repository->expects($this->once())
            ->method('create')
            ->with(
                $newChat->id,
                $message,
            );

        $service->create(
            Uuid::fromString($sender->uuid),
            Uuid::fromString($recipient->uuid),
            $message
        );
    }

    public function testCreateMessageWithInvalidSenderUuidThrowException(): void
    {
        $repository = $this->createMock(MessageRepository::class);
        $userRepository = $this->createMock(UserRepository::class);
        $chatRepository = $this->createMock(ChatRepository::class);

        $service = new CreateMessageService($repository, $userRepository, $chatRepository);

        $senderUuid = 'f0ea6a1f-5ea6-43ba-aa41-a9a6405ea44c';

        $recipient = new User([
            'uuid' => 'b97508ca-69cd-4848-a06f-163da2ca5118',
        ]);

        $message = 'test-message';

        $userRepository->expects($this->once())
            ->method('findByUuid')
            ->with($senderUuid)
            ->willReturn(null);

        $this->expectExceptionObject(MessageException::senderNotFound());

        $service->create(
            Uuid::fromString($senderUuid),
            Uuid::fromString($recipient->uuid),
            $message
        );
    }

    public function testCreateMessageWithInvalidRecipientUuidThrowException(): void
    {
        $repository = $this->createMock(MessageRepository::class);
        $userRepository = $this->createMock(UserRepository::class);
        $chatRepository = $this->createMock(ChatRepository::class);

        $service = new CreateMessageService($repository, $userRepository, $chatRepository);

        $sender = new User([
            'uuid' => '1153409a-9db2-4fb3-9a4f-0a0927854077'
        ]);

        $recipientUuid = '0a854943-45fb-4afc-9c6e-1a2bd0791d41';

        $message = 'test-message';

        $userRepository->expects($this->exactly(2))
            ->method('findByUuid')
            ->withConsecutive([$sender->uuid], [$recipientUuid])
            ->willReturnOnConsecutiveCalls($sender, null);

        $this->expectExceptionObject(MessageException::recipientNotFound());

        $service->create(
            Uuid::fromString($sender->uuid),
            Uuid::fromString($recipientUuid),
            $message
        );
    }
}
