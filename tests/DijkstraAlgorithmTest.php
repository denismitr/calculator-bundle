<?php

declare(strict_types=1);


namespace Denismitr\CalculatorBundle\Tests;


use Denismitr\CalculatorBundle\Algorithms\DijkstraTwoStackAlgorithm;
use Denismitr\CalculatorBundle\Exceptions\BadOperationException;
use PHPUnit\Framework\TestCase;

class DijkstraAlgorithmTest extends TestCase
{
    /**
     * @var DijkstraTwoStackAlgorithm
     */
    private $algorithm;

    protected function setUp(): void
    {
        parent::setUp();

        $this->algorithm = new DijkstraTwoStackAlgorithm();
    }

    /**
     * @test
     * @dataProvider simpleOperationsProvider
     * @param string $expression
     * @param float $expected
     * @throws BadOperationException
     */
    public function it_can_calculate_simple_operations_without_priority(string $expression, float $expected)
    {
        $this->assertEquals($expected, $this->algorithm->evaluate($expression));
    }

    /**
     * @test
     * @dataProvider priorityOperationsProvider
     * @param string $expression
     * @param float $expected
     * @throws BadOperationException
     */
    public function it_can_calculate_priority_operations(string $expression, float $expected)
    {
        $this->assertEquals($expected, $this->algorithm->evaluate($expression));
    }

    /**
     * @test
     */
    public function it_will_throw_on_division_by_zero()
    {
        $this->expectException(BadOperationException::class);
        $this->expectExceptionMessage('Divisions by zero: 2 / 0');

        $this->algorithm->evaluate("2 / 0");
    }

    /**
     * @test
     */
    public function it_will_throw_on_unsupported_operation()
    {
        $this->expectException(BadOperationException::class);
        $this->expectExceptionMessage("Token '$' cannot be part of expression");

        $this->algorithm->evaluate("2 $ 4");
    }

    /**
     * @test
     */
    public function it_will_throw_on_unsupported_symbol()
    {
        $this->expectException(BadOperationException::class);
        $this->expectExceptionMessage("Token 'a' cannot be part of expression");

        $this->algorithm->evaluate("a * 56");
    }

    public function simpleOperationsProvider(): array
    {
        return [
            ["1 + 1", 2],
            ["6 + 1", 7],
            ["6 + 8 + 2", 16],
            ["5 - 2", 3],
            ["10 - 2 - 3", 5],
            ["10 + 2 - 3", 9],
            ["10 + 2 - 3 - 3", 6],
            ["10 - 12", -2],
            ["10 * 2", 20],
            ["10 / 2", 5],
            ["5 / 2", 2.5],
        ];
    }

    public function  priorityOperationsProvider(): array
    {
        return [
            ["1 + 2 * 5", 11],
            ["3 * 3 - 5", 4],
            ["2 * 3 - 5", 1],
            ["2 * 2 - 5", -1],
            ["2 * 2 + 5", 9],
            ["2 * 2 + 5 - 1", 8],
            ["2 + 2 * 5 - 1", 11],
            ["2 - 1 + 2 * 15", 31],
            ["24 / 34 + 9 - 17 + 100 - 9 + 89", 172.70588235294],
            ["1345 - 987 / 45 - 100 - 900 - 3984 + 875 * 24", 17339.066666666666],
            ["1345 - 987 / 45 - 100 - 900 - 3984 + 875 * 24 - 199", 17140.066666666666],
            ["1345 - 987 / 12 - 100 - 900", 262.75],
        ];
    }
}