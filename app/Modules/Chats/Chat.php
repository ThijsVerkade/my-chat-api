<?php

namespace App\Modules\Chats;

use App\Modules\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'id',
        'uuid',
        'sender_id',
        'recipient_id',
    ];

    /** @var array<int, string> */
    protected $visible = [
        'uuid',
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
}
