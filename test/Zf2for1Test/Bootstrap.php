<?php

namespace Zf2for1Test;

use Zend\Loader\AutoloaderFactory;

chdir(dirname(__DIR__));
error_reporting(E_ALL | ~E_STRICT);

class Bootstrap
{
    protected static $testConfig;

    public static function init()
    {
        if (is_readable(__DIR__ . '/../testConfig.php')) {
            static::$testConfig = include __DIR__ . '/../testConfig.php';
        } else {
            static::$testConfig = include __DIR__ . '/../testConfig.php.dist';
        }
        static::initAutoloader();
    }

    public static function getTestConfig()
    {
        return static::$testConfig;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (is_readable($vendorPath . '/autoload.php')) {
            $loader = include $vendorPath . '/autoload.php';
        } else {
            throw new RuntimeException(
                'Run `php composer.phar install --dev` to install ZF1 and ZF2 frameworks.'
            );
        }

        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) return false;
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();
