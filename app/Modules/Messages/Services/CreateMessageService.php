<?php

namespace App\Modules\Messages\Services;

use App\Modules\Chats\Repositories\ChatRepository;
use App\Modules\Messages\Exceptions\MessageException;
use App\Modules\Messages\Repositories\MessageRepository;
use App\Modules\Users\Repositories\UserRepository;
use Ramsey\Uuid\UuidInterface;

final class CreateMessageService
{
    public function __construct(
        private MessageRepository $repository,
        private UserRepository $userRepository,
        private ChatRepository $chatRepository,
    ) {
    }

    public function create(
        UuidInterface $senderUuid,
        UuidInterface $recipientUuid,
        string $message,
    ): void{
        $sender = $this->userRepository->findByUuid($senderUuid);

        if (is_null($sender)) {
            throw MessageException::senderNotFound();
        }

        $recipient = $this->userRepository->findByUuid($recipientUuid);

        if (is_null($recipient)) {
            throw MessageException::recipientNotFound();
        }

        $chat = $this->chatRepository->findBySenderIdAndRecipientId($sender->id, $recipient->id);

        if (is_null($chat)) {
            $chat = $this->chatRepository->create($sender->id, $recipient->id);
        }

        $this->repository->create($chat->id, $message);
    }
}
