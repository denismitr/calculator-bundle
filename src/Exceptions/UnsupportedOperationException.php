<?php


namespace Denismitr\CalculatorBundle\Exceptions;


class UnsupportedOperationException extends \RuntimeException
{
    /**
     * @param string $message
     * @return UnsupportedOperationException
     */
    public static function because(string $message): self
    {
        return new static($message);
    }
}