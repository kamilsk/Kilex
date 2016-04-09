<?php

namespace OctoLab\Kilex\ServiceProvider;

use Monolog\Logger;
use OctoLab\Kilex\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
class MonologServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function setupSuccess()
    {
        $app = $this->getApplication();
        $this->getConfigServiceProviderForMonolog()->setup($app);
        (new MonologServiceProvider())->setup($app);
        $app['app.name'] = 'test';
        self::assertInstanceOf(LoggerInterface::class, $app['logger']);
        self::assertInstanceOf(Logger::class, $app['loggers']['app']);
        self::assertInstanceOf(Logger::class, $app['loggers']['debug']);
        self::assertInstanceOf(Logger::class, $app['loggers']['db']);
        self::assertEquals($app['logger'], $app['loggers'][$app['config']['monolog:default_channel']]);
        self::assertEquals($app['app.name'], $app['logger']->getName());
        $output = new BufferedOutput();
        $app['monolog.bridge']($output);
        /** @var \Monolog\Logger $logger */
        foreach ($app['loggers'] as $logger) {
            self::assertInstanceOf(ConsoleHandler::class, $logger->popHandler());
        }
    }

    /**
     * @test
     */
    public function setupEmpty()
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
