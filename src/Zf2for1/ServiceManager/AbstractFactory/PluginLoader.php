<?php

namespace Zf2for1\ServiceManager\AbstractFactory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend_Loader_PluginLoader;
use Zend_Loader_PluginLoader_Interface as PluginLoaderInterface;

class PluginLoader implements AbstractFactoryInterface
{
    protected $pluginLoader;

    public function getPluginLoader()
    {
        if ($this->pluginLoader == null) {
            $this->pluginLoader = new Zend_Loader_PluginLoader;
        }
        return $this->pluginLoader;
    }

    public function setPluginLoader(PluginLoaderInterface $pl)
    {
        $this->pluginLoader = $pl;
        return $this;
    }

    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if ($this->pluginLoader == null) {
            //PL can't load anything if not created and configured
            return false;
        }
        return (bool)$this->pluginLoader->load($name, false);
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $class = $this->getPluginLoader()->load($name);
        return new $class();
    }
}
