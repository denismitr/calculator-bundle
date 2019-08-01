<?php


namespace Denismitr\CalculatorBundle\Algorithms;


interface Evaluator
{
    public function evaluate(string $expression): float;
}