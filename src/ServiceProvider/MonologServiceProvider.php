<?php

declare(strict_types = 1);

namespace OctoLab\Kilex\ServiceProvider;

use OctoLab\Common\Monolog\LoggerLocator;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
class MonologServiceProvider
{
    /**
     * @param \Pimple $app
     *
     * @throws \InvalidArgumentException
     *
     * @api
     *
     * @quality:method [B]
     */
    public function setup(\Pimple $app)
    {
        if (!$app->offsetExists('config') || !isset($app->offsetGet('config')['monolog'])) {
            return;
        }
        $config = $app->offsetGet('config');
        $app['loggers'] = $app::share(function (\Pimple $app) use ($config) {
            return new LoggerLocator((array)$config['monolog'], $app['app.name']);
        });
        $app['logger'] = $app::share(function (\Pimple $app) {
            return $app['loggers']->getDefaultChannel();
        });
        $app['monolog.bridge'] = $app::share(function (\Pimple $app) {
            return function (OutputInterface $output) use ($app) {
                if (class_exists('Symfony\Bridge\Monolog\Handler\ConsoleHandler')
                    && interface_exists('Symfony\Component\EventDispatcher\EventSubscriberInterface')) {
                    $consoleHandler = new ConsoleHandler($output);
                    /** @var \Monolog\Logger $logger */
                    foreach ($app['loggers'] as $logger) {
                        $logger->pushHandler($consoleHandler);
                    }
                }
            };
        });
    }
}
