<?php

declare(strict_types=1);


namespace Denismitr\CalculatorBundle\Exceptions;


class UnsupportedAlgorithmException extends \RuntimeException
{
    /**
     * @param string $message
     * @return UnsupportedAlgorithmException
     */
    public static function because(string $message)
    {
        return new static($message);
    }
}