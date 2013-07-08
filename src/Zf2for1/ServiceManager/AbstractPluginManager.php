<?php

namespace Zf2for1\ServiceManager;

use Zend\ServiceManager\AbstractPluginManager as BaseAbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend_Loader_PluginLoader_Interface as PluginLoaderInterface;

abstract class AbstractPluginManager
    extends BaseAbstractPluginManager
    implements PluginLoaderInterface
{
    protected $fallbackPluginLoaderFactory;

    public function __construct(ConfigInterface $config = null)
    {
        parent::__construct($config);
        $this->fallbackPluginLoaderFactory = new AbstractFactory\PluginLoader;
    }

    public function setPluginLoader(PluginLoaderInterface $pl)
    {
        $this->fallbackPluginLoaderFactory->setPluginLoader($pl);
        return $this;
    }

    public function getPluginLoader()
    {
        return $this->fallbackPluginLoaderFactory->getPluginLoader();
    }

    /*
     * PluginLoaderInterface methods
     */

    /**
     * Proxy to fallback plugin loader
     *
     * {@inheritdoc}
     */
    public function addPrefixPath($prefix, $path)
    {
        $this->getPluginLoader()->addPrefixPath($prefix, $path);
        return $this;
    }

    /**
     * Proxy to fallback plugin loader
     *
     * {@inheritdoc}
     */
    public function removePrefixPath($prefix, $path = null)
    {
        $this->getPluginLoader()->removePrefixPath($prefix, $path);
        return $this;
    }

    /**
     * @see has()
     *
     * {@inheritdoc}
     *
     */
    public function isLoaded($name)
    {
        return $this->has($name);
    }

    /**
     * @see get()
     *
     * {@inheritdoc}
     *
     */
    public function load($name)
    {
        return $this->get($name);
    }
}
