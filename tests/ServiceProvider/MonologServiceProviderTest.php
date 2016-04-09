<?php

namespace OctoLab\Kilex\ServiceProvider;

use Monolog\Logger;
use OctoLab\Kilex\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
class MonologServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function registerSuccess()
    {
        $app = $this->getApplication();
        $this->getConfigServiceProviderForMonolog()->setup($app);
        (new MonologServiceProvider())->setup($app);
        self::assertInstanceOf(LoggerInterface::class, $app['logger']);
        self::assertInstanceOf(Logger::class, $app['loggers']['app']);
        self::assertInstanceOf(Logger::class, $app['loggers']['debug']);
        self::assertInstanceOf(Logger::class, $app['loggers']['db']);
        self::assertEquals($app['logger'], $app['loggers'][$app['config']['monolog:default_channel']]);
        self::assertEquals($app['console.name'], $app['logger']->getName());
    }

    /**
     * @test
     */
    public function registerEmpty()
    {
        $app = $this->getApplication();
        (new MonologServiceProvider())->setup($app);
        try {
            $app->offsetGet('logger');
            self::fail(sprintf('%s exception expected.', \InvalidArgumentException::class));
        } catch (\InvalidArgumentException $e) {
            self::assertTrue(true);
        }
    }
}
