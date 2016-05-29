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
     * @throws \InvalidArgumentException
     * @throws \Doctrine\DBAL\DBALException
     *
     * @api
     */
    public function setup(\Pimple $app)
    {
        $config = $app['config'];
        assert('$config instanceof \OctoLab\Common\Config\SimpleConfig');
        ConfigResolver::resolve($config['doctrine:dbal']);
        $app['connections'] = $app::share(function () use ($config) : \Pimple {
            $connections = new \Pimple();
            foreach ($config['doctrine:dbal:connections'] as $id => $params) {
                assert('is_string($id)');
                $connections[$id] = DriverManager::getConnection($params);
            }
            return $connections;
        });
        $app['connection'] = $app::share(function (\Pimple $app) use ($config) : \Doctrine\DBAL\Connection {
            $ids = $app['connections']->keys();
            $default = $config['doctrine:dbal:default_connection'] ?: current($ids);
            return $app['connections'][$default];
        });
    }
}
