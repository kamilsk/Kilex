<?php

declare(strict_types = 1);

namespace OctoLab\Kilex\ServiceProvider;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use OctoLab\Kilex\TestCase;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
class DoctrineServiceProviderTest extends TestCase
{
    /**
     * @test
     *
     * @throws \Exception
     */
    public function setupSuccess()
    {
        $app = $this->getApplication();
        $this->getConfigServiceProviderForDoctrine()->setup($app);
        (new DoctrineServiceProvider())->setup($app);
        self::assertInstanceOf(Connection::class, $app['connection']);
        self::assertInstanceOf(Connection::class, $app['connections']['mysql']);
        self::assertInstanceOf(Connection::class, $app['connections']['sqlite']);
        self::assertEquals($app['connection'], $app['connections'][$app['config']['doctrine:dbal:default_connection']]);
        foreach ($app['config']['doctrine:dbal:types'] as $type => $_) {
            self::assertTrue(Type::hasType($type));
        }
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Identifier "config" is not defined.
     */
    public function setupFailure()
    {
        $app = $this->getApplication();
        (new DoctrineServiceProvider())->setup($app);
        $app->offsetGet('connection');
    }
}
