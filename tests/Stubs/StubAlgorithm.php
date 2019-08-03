<?php

declare(strict_types=1);

namespace Denismitr\CalculatorBundle\Tests\Stubs;


use Denismitr\CalculatorBundle\Algorithms\Evaluator;

class StubAlgorithm implements Evaluator
{
    public function evaluate(string $expression): float
    {
        return 222;
    }
}