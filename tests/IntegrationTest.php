<?php

declare(strict_types=1);

namespace Denismitr\CalculatorBundle\Tests;


use Denismitr\CalculatorBundle\Calculator;
use Denismitr\CalculatorBundle\Tests\Kernel\CalculatorTestKernel;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    /**
     * @test
     */
    public function it_wires_the_calculator_correctly_with_default_algorithm()
    {
        $kernel = new CalculatorTestKernel();
        $kernel->boot();

        $container = $kernel->getContainer();
        $calculator = $container->get('denismitr_calculator.calculator');

        $this->assertInstanceOf(Calculator::class, $calculator);

        $result = $calculator->evaluate("1 + 3");
        $this->assertEquals(4, $result);
        $this->assertInternalType('float', $result);
    }

    /**
     * @test
     */
    public function it_wires_the_calculator_correctly_with_stub_algorithm()
    {
        $kernel = new CalculatorTestKernel([
            'algorithm' => 'stub_algorithm'
        ]);

        $kernel->boot();

        $container = $kernel->getContainer();
        $calculator = $container->get('denismitr_calculator.calculator');

        $this->assertInstanceOf(Calculator::class, $calculator);

        $result = $calculator->evaluate("any input will do");
        $this->assertEquals(222, $result);
        $this->assertInternalType('float', $result);
    }
}