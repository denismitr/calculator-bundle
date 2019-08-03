<?php

declare(strict_types=1);

namespace Denismitr\CalculatorBundle\Exceptions;

use Exception;

class BadOperationException extends Exception
{
    /**
     * @param string $message
     * @return BadOperationException
     */
    public static function because(string $message): self
    {
        return new static($message);
    }
}