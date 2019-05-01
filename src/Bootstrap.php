<?php

class Bootstrap
{
    public static function run()
    {
        self::configureAutoloader();
    }

    public static function configureAutoloader()
    {
        // composer
        include_once __DIR__ . '/../vendor/autoload.php';

        // app
        include_once __DIR__ . '/Autoloader.php';
        Autoloader::registerAutoloader();
    }
}
