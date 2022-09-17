<?php

namespace App\Modules\Chats\Repositories;

use App\Modules\Chats\Chat;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ChatRepository
{
    public function create(int $senderId, int $recipientId): Chat
    {
        $chat = new Chat([
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
        ]);

        $chat->save();

        return $chat;
    }

    public function findBySenderIdAndRecipientId(int $senderId, int $recipientId): ?chat
    {
        return Chat::where([
            ['sender_id', $senderId],
            ['recipient_id', $recipientId],
        ])->first();
    }
}
