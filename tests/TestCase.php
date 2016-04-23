<?php

declare(strict_types = 1);

namespace OctoLab\Kilex;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Pimple
     */
    public function getApplication(): \Pimple
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
    protected function getConfigServiceProvider(
        string $config,
        string $extension,
        array $placeholders = ['placeholder' => 'test']
    ): ServiceProvider\ConfigServiceProvider {
        return new ServiceProvider\ConfigServiceProvider($this->getConfigPath($config, $extension), $placeholders);
    }

    /**
     * @return ServiceProvider\ConfigServiceProvider
     */
    protected function getConfigServiceProviderForMonolog(): ServiceProvider\ConfigServiceProvider
    {
        return $this->getConfigServiceProvider('monolog/config', 'yml', ['root_dir' => __DIR__]);
    }

    /**
     * @return ServiceProvider\ConfigServiceProvider
     */
    protected function getConfigServiceProviderForDoctrine(): ServiceProvider\ConfigServiceProvider
    {
        return $this->getConfigServiceProvider('doctrine/config', 'yml');
    }

    /**
     * @param string $config
     * @param string $extension
     *
     * @return string
     */
    protected function getConfigPath(string $config = 'config', string $extension = 'yml'): string
    {
        return sprintf('%s/app/config/%s.%s', __DIR__, $config, $extension);
    }
}
