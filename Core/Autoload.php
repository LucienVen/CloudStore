<?php

namespace Core;

class Autoload
{
    public static function load($className)
    {
        $className = str_replace(['\\', '_'], DIRECTORY_SEPARATOR, $className);
        $loadPath = ROOT_PATH.$className.".php";
        if (file_exists($loadPath)) {
            require $loadPath;
        } else {
            throw new \Core\DefException("File does not exist!", 404);
        }
    }
}
