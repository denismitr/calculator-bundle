<?php

declare(strict_types=1);

namespace Denismitr\CalculatorBundle\Algorithms;


use Denismitr\CalculatorBundle\Exceptions\BadOperationException;
use SplStack as Stack;


final class DijkstraTwoStackAlgorithm implements Evaluator
{
    /**
     * Operators stack
     * @var Stack
     */
    private $operators;

    /**
     * Values stack
     *
     * @var Stack
     */
    private $values;

    /**
     * @param string $expression
     * @return float
     * @throws BadOperationException
     */
    public function evaluate(string $expression): float
    {
        $this->initialize();

        $tokens = $this->parseString($expression);

        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $this->values->push(floatval($token));
                continue;
            }

            if ( ! $this->isLegalOperator($token)) {
                throw BadOperationException::because("Token '{$token}' cannot be part of expression");
            }

            $this->operators->push($token);
        }

        $this->apply();

        return $this->values->pop();
    }

    private function apply()
    {
        while ( ! $this->operators->isEmpty() && $this->values->count() >= 2) {
            $right = $this->values->pop();
            $left = $this->values->pop();
            $operator = $this->operators->pop();

            if ($this->nextOperatorHasHigherPriority($operator)) {
                $nextRight = $this->values->pop();
                $nextOperator = $this->operators->pop();
                $this->operators->push($operator); // return initial operator back to the stack
                $this->values->push($this->combine($nextRight, $left, $nextOperator));
                $this->values->push($right); // return initial operator back to the stack
                continue;
            }

            if ($this->nextOperatorIsSubtraction()) {
                $right = $right * -1;
            }

            $this->values->push($this->combine($left, $right, $operator));
        }
    }

    /**
     * @param float $left
     * @param float $right
     * @param string $operator
     * @return float
     * @throws BadOperationException
     */
    private function combine(float $left, float $right, string $operator): float
    {
        switch ($operator) {
            case '+':
                return $left + $right;
            case '-':
                return $left - $right;
            case '*':
                return $left * $right;
            case '/':
                if ($right == 0) {
                    throw BadOperationException::because("Divisions by zero: {$left} / {$right}");
                }

                return $left / $right;
            default:
                throw BadOperationException::because("Operator {$operator} is not supported");
        }
    }

    /**
     * @param string $expression
     * @return array
     * @throws BadOperationException
     */
    private function parseString(string $expression): array
    {
        if (strlen($expression) === 0) {
            throw BadOperationException::because("Expression is empty");
        }

        return explode(' ', $expression);
    }

    /**
     * @param string $operator
     * @return bool
     */
    private function nextOperatorHasHigherPriority(string $operator): bool
    {
        if ($operator === '/' || $operator === '*') return false;

        return !$this->operators->isEmpty() && ($this->operators->top() === '*' || $this->operators->top() === '/');
    }

    /**
     * @return bool
     */
    private function nextOperatorIsSubtraction(): bool
    {
        return !$this->operators->isEmpty() && $this->operators->top() === '-';
    }

    /**
     * @param string $operator
     * @return bool
     */
    private function isLegalOperator(string $operator): bool
    {
        return in_array($operator, ['*', '/', '-', '+']);
    }

    private function initialize(): void
    {
        $this->operators = new Stack();
        $this->values = new Stack();
    }
}