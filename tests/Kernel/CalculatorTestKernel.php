<?php


namespace Denismitr\CalculatorBundle\Tests\Kernel;


use Denismitr\CalculatorBundle\CalculatorBundle;
use Denismitr\CalculatorBundle\Tests\Stubs\StubAlgorithm;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class CalculatorTestKernel extends Kernel
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;

        parent::__construct('test', true);
    }


    /**
     * Returns an array of bundles to register.
     *
     * @return iterable|BundleInterface[] An iterable of bundle instances
     */
    public function registerBundles()
    {
        return [
            new CalculatorBundle()
        ];
    }

    /**
     * Loads the container configuration.
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function(ContainerBuilder $builder) {
            $builder->register('stub_algorithm', StubAlgorithm::class);
            $builder->loadFromExtension('denismitr_calculator', $this->config);
        });
    }

    public function getCacheDir()
    {
        return __DIR__.'/../cache/'.spl_object_hash($this);
    }


}