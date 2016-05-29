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
     * @dataProvider configProvider
     *
     * @param string $extension
     * @param array $expected
     */
    public function setupSuccess(string $extension, array $expected)
    {
        $app = $this->getApplication();
        $this->getConfigServiceProvider('config', $extension)->setup($app);
        foreach ($expected as $key => $value) {
            self::assertEquals($value, $app['config'][$key]);
        }
    }

    /**
     * @test
     */
    public function setupFailure()
    {
        $this->setExpectedException(
            \DomainException::class,
            sprintf('The file "%s" is not supported.', $this->getConfigPath('others/unsupported', 'file'))
        );
        $app = $this->getApplication();
        $this->getConfigServiceProvider('others/unsupported', 'file')->setup($app);
        $app->offsetGet('config');
    }

    /**
     * @return array
     */
    public function configProvider(): array
    {
        return [
            ['ini', $this->expected],
            ['json', $this->expected],
            ['php', $this->expected],
            ['yml', $this->expected],
        ];
    }
}
