<?php

declare(strict_types=1);


namespace Denismitr\CalculatorBundle;


use Denismitr\CalculatorBundle\Algorithms\Evaluator;

class Calculator
{
    /**
     * @var Evaluator
     */
    private $evaluator;

    /**
     * Calculator constructor.
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * @param string $expression
     * @return float
     */
    public function evaluate(string $expression): float
    {
        return $this->evaluator->evaluate($expression);
    }
}