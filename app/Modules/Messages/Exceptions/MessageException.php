<?php

namespace App\Modules\Messages\Exceptions;

use App\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

class MessageException extends ApiException
{
    public static function senderNotFound(
        string $message = null,
        \Throwable $previous = null,
    ): self {
        if (is_null($message)) {
            $message = 'Sender not found';
        }

        return new self('sender_not_found', $message, null, Response::HTTP_NOT_FOUND, $previous);
    }

     public static function recipientNotFound(
        string $message = null,
        \Throwable $previous = null,
    ): self {
        if (is_null($message)) {
            $message = 'Recipient not found';
        }

        return new self('recipient_not_found', $message, null, Response::HTTP_NOT_FOUND, $previous);
    }
}
