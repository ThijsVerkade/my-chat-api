<?php

namespace App\Modules\Users;

use App\Modules\Messages\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'id',
        'uuid',
        'name',
        'email',
    ];

    /** @var array<int, string> */
    protected $visible = [
        'uuid',
        'name',
        'email',
    ];

    public function fromMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender');
    }

    public function toMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'recipient');
    }
}
