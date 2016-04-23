<?php

declare(strict_types = 1);

namespace OctoLab\Kilex;

use OctoLab\Common\Test\ClassAvailability;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
class ClassAvailabilityTest extends ClassAvailability
{
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
        static $excluded = [
            // no dependencies
            '\Silex\ConstraintValidatorFactory' => true,
            '\Silex\Translator' => true,
            '\Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass' => true,
            '\Symfony\Component\HttpKernel\Bundle\Bundle' => true,
            '\Symfony\Component\HttpKernel\Bundle\BundleInterface' => true,
            '\Symfony\Component\HttpKernel\Client' => true,
            '\Symfony\Component\HttpKernel\DataCollector\DumpDataCollector' => true,
            '\Symfony\Component\HttpKernel\DependencyInjection\AddClassesToCachePass' => true,
            '\Symfony\Component\HttpKernel\DependencyInjection\Extension' => true,
        ];
        return strpos($class, 'OctoLab\Common\Doctrine\Migration') === 0
            || strpos($class, 'Symfony\Component\HttpKernel') === 0
            || !empty($excluded[$class])
            || !empty($excluded['\\' . $class]);
    }
}
