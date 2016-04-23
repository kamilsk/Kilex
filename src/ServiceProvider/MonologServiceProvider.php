<?php

declare(strict_types = 1);

namespace OctoLab\Kilex\ServiceProvider;

use OctoLab\Common\Monolog\Service\ComponentFactory;
use OctoLab\Common\Monolog\Service\Locator;
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
     */
    public function setup(\Pimple $app)
    {
        $config = $app->offsetGet('config');
        $app['loggers'] = $app::share(function (\Pimple $app) use ($config) {
            return new Locator((array)$config['monolog'], $app['monolog.component_factory'], $app['app.name']);
        });
        $app['logger'] = $app::share(function (\Pimple $app) {
            return $app['loggers']->getDefaultChannel();
        });
        $app['monolog.bridge'] = $app::share(function (\Pimple $app) {
            return $this->getBridge($app);
        });
        $app['monolog.component_factory'] = $app::share(function () {
            return ComponentFactory::withDefaults();
        });
    }

    /**
     * @param \Pimple $app
     *
     * @return \Closure
     */
    private function getBridge(\Pimple $app): \Closure
    {
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
    }
}
