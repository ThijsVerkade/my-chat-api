<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\ApiException;
use PHPUnit\Framework\TestCase;

class ApiExceptionTest extends TestCase
{
    public function testGetErrorCode(): void
    {
        $apiException = new ApiException('invalid_code', 'Invalid code', null);
        self::assertEquals('invalid_code', $apiException->getErrorCode());
    }

    public function testGetDetails(): void
    {
        $apiException = new ApiException('invalid_code', 'Invalid code', null);
        self::assertEquals(null, $apiException->getDetails());
    }
}
