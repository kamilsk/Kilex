<?php

declare(strict_types = 1);

namespace OctoLab\Kilex\ServiceProvider;

use Doctrine\DBAL\DriverManager;
use OctoLab\Common\Doctrine\Util\ConfigResolver;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
class DoctrineServiceProvider
{
    /**
     * @param \Pimple $app
     *
     * @throws \Doctrine\DBAL\DBALException
     *
     * @api
     *
     * @quality:method [B]
     */
    public function setup(\Pimple $app)
    {
        if (!$app->offsetExists('config') || !isset($app->offsetGet('config')['doctrine'])) {
            return;
        }
        $config = $app->offsetGet('config');
        ConfigResolver::resolve((array)$config['doctrine:dbal']);
        $app['connections'] = $app::share(function () use ($config) {
            $connections = new \Pimple();
            foreach ((array)$config['doctrine:dbal:connections'] as $id => $params) {
                $connections->offsetSet($id, DriverManager::getConnection($params));
            }
            return $connections;
        });
        $app['connection'] = $app::share(function (\Pimple $app) use ($config) {
            $ids = $app['connections']->keys();
            $default = $config['doctrine:dbal:default_connection'] ?: current($ids);
            return $app['connections'][$default];
        });
    }
}
