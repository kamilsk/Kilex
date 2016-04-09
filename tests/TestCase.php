<?php

namespace OctoLab\Kilex;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Pimple
     */
    public function getApplication()
    {
        return new \Pimple();
    }

    /**
     * @param string $config
     * @param string $extension
     * @param array $placeholders
     *
     * @return ServiceProvider\ConfigServiceProvider
     */
    protected function getConfigServiceProvider($config, $extension, array $placeholders = ['placeholder' => 'test'])
    {
        return new ServiceProvider\ConfigServiceProvider($this->getConfigPath($config, $extension), $placeholders);
    }

    /**
     * @param string $config
     * @param string $extension
     *
     * @return string
     */
    protected function getConfigPath($config = 'config', $extension = 'yml')
    {
        return sprintf('%s/app/config/%s.%s', __DIR__, $config, $extension);
    }
}
