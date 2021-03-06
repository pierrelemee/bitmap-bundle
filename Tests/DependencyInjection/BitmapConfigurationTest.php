<?php

namespace Bitmap\Bundle\BitmapBundle\Tests\DependencyInjection;


use Bitmap\Bundle\BitmapBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class BitmapConfigurationTest extends TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testEmptyConfiguration()
    {
        $this->process([]);

    }

    /**
     * Processes an array of configurations and returns a compiled version.
     *
     * @param array $configs An array of raw configurations
     *
     * @return array A normalized array
     */
    protected function process(array $configs)
    {
        $processor = new Processor();
        return $processor->processConfiguration(new Configuration(), $configs);
    }
}