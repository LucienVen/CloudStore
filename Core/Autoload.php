<?php

/**
 * atuoload class
 */
class Autoload
{
    /**
     * load function
     *
     * @param string $className
     * @return void
     * @throws \Core\DefException
     */
    public static function load($className)
    {
        // turn the special symbol to directory separator
        $className = str_replace(['\\', '_'], DIRECTORY_SEPARATOR, $className);
        $loadPath = ROOT_PATH.DIRECTORY_SEPARATOR.$className.".php";
        if (file_exists($loadPath)) {
            require $loadPath;
        } else {
            throw new \Core\DefException("Load: ".$loadPath."<br>File does not exist!", 404);
        }
    }
}
