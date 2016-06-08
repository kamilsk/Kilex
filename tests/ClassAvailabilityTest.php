<?php

declare(strict_types = 1);

namespace OctoLab\Kilex;

use OctoLab\Common\Test\ClassAvailability;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
class ClassAvailabilityTest extends ClassAvailability
{
    const EXCLUDED = [
        // no dependencies
        'OctoLab\\Common\\Command\\Doctrine\\CheckMigrationCommand' => ['doctrine/migrations'],
        'Symfony\\Bridge\\Monolog\\Logger' => ['symfony/http-foundation', 'symfony/http-kernel'],
        'Symfony\\Bridge\\Twig\\DataCollector\\TwigDataCollector' => ['symfony/http-kernel', 'symfony/http-foundation'],
        'Symfony\\Bridge\\Twig\\TwigEngine' => ['symfony/templating'],
    ];
    const GROUP_EXCLUDED = [
        // no dependencies
        'OctoLab\\Common\\Doctrine\\Migration' => ['doctrine/migrations'],
        'Symfony\\Bridge\\Monolog\\Handler' => ['symfony/http-foundation', 'symfony/http-kernel'],
        'Symfony\\Bridge\\Monolog\\Processor' => ['symfony/http-foundation', 'symfony/http-kernel'],
        'Symfony\\Bridge\\Twig\\Form' => [
            'symfony/expression-language',
            'symfony/form',
            'symfony/http-foundation',
            'symfony/http-kernel',
            'symfony/routing',
            'symfony/security',
            'symfony/stopwatch',
            'symfony/translation',
            'symfony/var-dumper',
        ],
        'Symfony\\Bridge\\Twig\\Translation' => ['symfony/translation'],
        'Symfony\\Component\\EventDispatcher\\DependencyInjection' => ['symfony/dependency-injection'],
    ];

    /**
     * {@inheritdoc}
     */
    protected function getClasses(): \Generator
    {
        foreach (require dirname(__DIR__) . '/vendor/composer/autoload_classmap.php' as $class => $path) {
            $signal = yield $class;
            if (SIGSTOP === $signal) {
                return;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function isFiltered(string $class): bool
    {
        foreach (self::GROUP_EXCLUDED as $group => $isOn) {
            if ($isOn && strpos($class, $group) === 0) {
                return true;
            }
        }
        return array_key_exists($class, self::EXCLUDED) && self::EXCLUDED[$class];
    }
}
