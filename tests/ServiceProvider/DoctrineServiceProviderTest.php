<?php

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
     */
    public function setupEmpty()
    {
        $app = $this->getApplication();
        (new DoctrineServiceProvider())->setup($app);
        try {
            $app->offsetGet('connection');
            self::fail(sprintf('%s exception expected.', \InvalidArgumentException::class));
        } catch (\InvalidArgumentException $e) {
            self::assertTrue(true);
        }
    }
}
