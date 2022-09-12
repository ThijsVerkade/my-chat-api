<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Auth;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class User extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * @var array<int, string>
     */
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

    public function findByUuid(UuidInterface $uuid): ?self
    {
        return (new self)->where('uuid', $uuid->toString())->first();
    }
}
