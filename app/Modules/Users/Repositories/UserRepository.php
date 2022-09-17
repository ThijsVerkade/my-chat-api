<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\User;
use Ramsey\Uuid\UuidInterface;

class UserRepository
{
    public function findByUuid(UuidInterface $uuid): ?User
    {
        return User::where('uuid', $uuid->toString())->first();
    }
}
