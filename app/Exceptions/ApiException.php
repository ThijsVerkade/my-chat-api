<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Jsonable;

class ApiException extends \Exception
{
    public function __construct(
        private string $errorCode,
        protected string $errorMessage,
        private ?Jsonable $details,
        protected int $httpCode = 500,
        protected ?\Throwable $previous = null
    ) {
        parent::__construct($this->errorMessage, $this->httpCode, $this->previous);
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getDetails(): ?Jsonable
    {
        return $this->details;
    }
}
