<?php

namespace OctoLab\Kilex\ServiceProvider;

use OctoLab\Kilex\TestCase;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
class ConfigServiceProviderTest extends TestCase
{
    /** @var array */
    private $expected = [
        'app' => [
            'placeholder_parameter' => 'test',
            'constant' => E_ALL,
        ],
        'component' => [
            'parameter' => 'base component\'s parameter will be overwritten by root config',
            'base_parameter' => 'base parameter will not be overwritten',
        ],
    ];

    /**
     * @test
     */
    public function registerJsonConfig()
    {
        $app = $this->getApplication();
        $this->invokeInit($this->getConfigServiceProvider('config', 'json'), $app);
        foreach ($this->expected as $key => $value) {
            self::assertEquals($value, $app['config'][$key]);
        }
    }

    /**
     * @test
     */
    public function registerPhpConfig()
    {
        $app = $this->getApplication();
        $this->invokeInit($this->getConfigServiceProvider('config', 'php'), $app);
        foreach ($this->expected as $key => $value) {
            self::assertEquals($value, $app['config'][$key]);
        }
    }

    /**
     * @test
     */
    public function registerYamlConfig()
    {
        $app = $this->getApplication();
        $this->invokeInit($this->getConfigServiceProvider('config', 'yml'), $app);
        foreach ($this->expected as $key => $value) {
            self::assertEquals($value, $app['config'][$key]);
        }
    }

    /**
     * @test
     */
    public function registerUnsupportedConfig()
    {
        try {
            $app = $this->getApplication();
            $this->invokeInit($this->getConfigServiceProvider('config', 'xml'), $app);
            $app->offsetGet('config');
            self::fail(sprintf('%s exception expected.', \DomainException::class));
        } catch (\DomainException $e) {
            self::assertTrue(true);
        }
    }

    /**
     * @param ConfigServiceProvider $config
     * @param \Pimple $app
     */
    private function invokeInit(ConfigServiceProvider $config, \Pimple $app)
    {
        $reflection = (new \ReflectionObject($config))->getMethod('init');
        $reflection->setAccessible(true);
        $reflection->invoke($config, $app);
    }
}
