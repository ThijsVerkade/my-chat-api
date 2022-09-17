<?php

namespace App\Modules\Messages;

use App\Modules\Chats\Chat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'uuid',
        'message',
        'chat_id',
    ];

    /** @var array<int, string> */
    protected $visible = [
        'uuid',
        'message',
        'chat',
    ];

    public function chat(): HasMany
    {
        return $this->hasMany(Chat::class);
    }
}
