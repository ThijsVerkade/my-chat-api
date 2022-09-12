<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Message extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'message',
        'sender_id',
        'recipient_id',
    ];

    /**
     * @var array<int, string>
     */
    protected $visible = [
        'uuid',
        'text',
        'sender',
        'recipient',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function create(int $senderId, int $recipientId, string $message): void
    {
        $message = new self(
            [
                'uuid' => Uuid::uuid4()->toString(),
                'sender_id' => $senderId,
                'recipient_id' => $recipientId,
                'message' => $message
            ]
        );
        $message->save();
    }
}
