<?php

namespace OctoLab\Kilex\ServiceProvider;

use OctoLab\Common\Config;
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
    public function __construct($filename, array $placeholders = [])
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
     *
     * @quality:method [B]
     */
    public function setup(\Pimple $app)
    {
        $app['config'] = $app::share(function () {
            $ext = strtolower(pathinfo($this->filename, PATHINFO_EXTENSION));
            switch ($ext) {
                case 'yml':
                case 'json':
                    $parser = $ext === 'yml'
                        ? new Config\Loader\Parser\YamlParser()
                        : new Config\Loader\Parser\JsonParser();
                    $loader = new Config\Loader\FileLoader(new FileLocator(), $parser);
                    $config = (new Config\FileConfig($loader))->load($this->filename, $this->placeholders);
                    break;
                case 'php':
                    $config = (new Config\SimpleConfig(require $this->filename, $this->placeholders));
                    break;
                default:
                    throw new \DomainException(sprintf('File "%s" is not supported.', $this->filename));
            }
            return $config;
        });
    }
}
