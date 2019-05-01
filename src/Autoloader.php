<?php

class Autoloader
{
    public static function registerAutoloader()
    {
        spl_autoload_register(array('self', 'loader'), false);
    }

    public static function loader($className)
    {
        $className = str_replace('\\', '/', $className);

        $filePath = __DIR__ . '/' . $className . '.php';

        if (file_exists($filePath)) {
            include_once __DIR__ . '/' . $className . '.php';
        }
    }
}