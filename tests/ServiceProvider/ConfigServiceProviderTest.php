<?php

declare(strict_types = 1);

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
    public function setupJsonConfig()
    {
        $app = $this->getApplication();
        $this->getConfigServiceProvider('config', 'json')->setup($app);
        foreach ($this->expected as $key => $value) {
            self::assertEquals($value, $app['config'][$key]);
        }
    }

    /**
     * @test
     */
    public function setupPhpConfig()
    {
        $app = $this->getApplication();
        $this->getConfigServiceProvider('config', 'php')->setup($app);
        foreach ($this->expected as $key => $value) {
            self::assertEquals($value, $app['config'][$key]);
        }
    }

    /**
     * @test
     */
    public function setupYamlConfig()
    {
        $app = $this->getApplication();
        $this->getConfigServiceProvider('config', 'yml')->setup($app);
        foreach ($this->expected as $key => $value) {
            self::assertEquals($value, $app['config'][$key]);
        }
    }

    /**
     * @test
     */
    public function setupUnsupportedConfig()
    {
        try {
            $app = $this->getApplication();
            $this->getConfigServiceProvider('config', 'xml')->setup($app);
            $app->offsetGet('config');
            self::fail(sprintf('%s exception expected.', \DomainException::class));
        } catch (\DomainException $e) {
            self::assertTrue(true);
        }
    }
}
