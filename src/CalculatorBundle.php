<?php


namespace Denismitr\CalculatorBundle;


use Denismitr\CalculatorBundle\DependencyInjection\CalculatorExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CalculatorBundle extends Bundle
{
    public function getContainerExtension()
    {
        if ($this->extension === null) {
            $this->extension = new CalculatorExtension();
        }

        return $this->extension;
    }
}