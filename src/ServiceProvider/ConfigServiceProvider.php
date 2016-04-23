<?php

declare(strict_types = 1);

namespace OctoLab\Kilex\ServiceProvider;

use OctoLab\Common\Config\FileConfig;
use OctoLab\Common\Config\Loader\FileLoader;
use OctoLab\Common\Config\Loader\Parser\JsonParser;
use OctoLab\Common\Config\Loader\Parser\ParserInterface;
use OctoLab\Common\Config\Loader\Parser\YamlParser;
use OctoLab\Common\Config\SimpleConfig;
use Symfony\Component\Config\FileLocator;

/**
 * @author Kamil Samigullin <kamil@samigullin.info>
 */
class ConfigServiceProvider
{
    /** @var string */
    protected $filename;
    /** @var array */
    protected $placeholders;

    /**
     * @param string $filename
     * @param array $placeholders
     *
     * @api
     */
    public function __construct(string $filename, array $placeholders = [])
    {
        $this->filename = $filename;
        $this->placeholders = $placeholders;
    }

    /**
     * @param \Pimple $app
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @throws \Symfony\Component\Config\Exception\FileLoaderLoadException
     * @throws \Symfony\Component\Config\Exception\FileLoaderImportCircularReferenceException
     * @throws \DomainException
     *
     * @api
     */
    public function setup(\Pimple $app)
    {
        $app['config'] = $app::share(function () : SimpleConfig {
            $ext = strtolower(pathinfo($this->filename, PATHINFO_EXTENSION));
            switch ($ext) {
                case 'yml':
                case 'json':
                    $loader = new FileLoader(new FileLocator(), $this->getParser($ext));
                    $config = (new FileConfig($loader))->load($this->filename, $this->placeholders);
                    break;
                case 'php':
                    $config = (new SimpleConfig(require $this->filename, $this->placeholders));
                    break;
                default:
                    throw new \DomainException(sprintf('The file "%s" is not supported.', $this->filename));
            }
            return $config;
        });
    }

    /**
     * @param string $extension
     *
     * @return ParserInterface
     */
    private function getParser(string $extension): ParserInterface
    {
        return $extension === 'yml' ? new YamlParser() : new JsonParser();
    }
}
