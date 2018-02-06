<?php

declare(strict_types = 1);

namespace OctoLab\Kilex\ServiceProvider;

use OctoLab\Common\Config\FileConfig;
use OctoLab\Common\Config\Loader\FileLoader;
use OctoLab\Common\Config\Loader\Parser\IniParser;
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
        \assert('is_readable($filename)');
        $this->filename = $filename;
        $this->placeholders = $placeholders;
    }

    /**
     * @param \Pimple $app
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @throws \DomainException
     *
     * @api
     */
    public function setup(\Pimple $app)
    {
        $app['config'] = $app::share(function () : SimpleConfig {
            $ext = strtolower(pathinfo($this->filename, PATHINFO_EXTENSION));
            if (\in_array($ext, ['ini', 'json', 'yml', 'yaml'], true)) {
                $loader = new FileLoader(new FileLocator(), $this->getParser($ext));
                $config = (new FileConfig($loader))->load($this->filename, $this->placeholders);
            } elseif ($ext === 'php') {
                $config = (new SimpleConfig(require $this->filename, $this->placeholders));
            } else {
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
        switch (true) {
            case $extension === 'json':
                return new JsonParser();
            case $extension[0] === 'i':
                return new IniParser();
            default:
                return new YamlParser();
        }
    }
}
