<?php

namespace App\Exceptions\Message;

use App\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

class InvalidMessage extends ApiException
{
    public static function FromUserNotFound(
        string $message = null,
        \Throwable $previous = null,
    ): self {
        if (is_null($message)) {
            $message = 'From user not found';
        }

        return new self('sender_not_found', $message, null, Response::HTTP_NOT_FOUND, $previous);
    }

    public static function ToUserNotFound(
        string $message = null,
        \Throwable $previous = null,
    ): self {
        if (is_null($message)) {
            $message = 'To user not found';
        }

        return new self('recipient_not_found', $message, null, Response::HTTP_NOT_FOUND, $previous);
    }
}
