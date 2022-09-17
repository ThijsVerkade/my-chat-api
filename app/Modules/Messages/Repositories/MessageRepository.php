<?php

namespace App\Modules\Messages\Repositories;

use App\Modules\Messages\Message;
use Ramsey\Uuid\Uuid;

class MessageRepository
{
    public function create(int $chatId, string $message): Message
    {
        $message = new Message([
            'uuid' => Uuid::uuid4()->toString(),
            'chat_id' => $chatId,
            'message' => $message,
        ]);

        $message->save();

        return $message;
    }
}
