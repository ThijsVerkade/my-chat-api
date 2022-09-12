<?php

namespace App\Services;

use App\Exceptions\Message\InvalidMessage;
use App\Models\Message;
use App\Models\User;
use Ramsey\Uuid\UuidInterface;

final class MessageService
{
    public function __construct(
        private Message $message,
        private User $user
    ) {
    }

    public function create(UuidInterface $senderUuid, UuidInterface $recipientUuid, string $message): void
    {
        $sender = $this->user->findByUuid($senderUuid);

        if (is_null($sender)) {
            throw InvalidMessage::FromUserNotFound();
        }

        $recipient = $this->user->findByUuid($recipientUuid);

        if (is_null($recipient)) {
            throw InvalidMessage::ToUserNotFound();
        }

        $this->message->create($sender->id, $recipient->id, $message);
    }
}
