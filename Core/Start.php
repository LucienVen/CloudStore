<?php

namespace Core;

/**
 * singleton design pattern
 */
class Start
{
    /**
     * object instance
     *
     * @var \Core\Start
     */
    private static $instance;

    /**
     * Slim instance
     *
     * @var \Slim\App
     */
    private static $app;

    /**
     * singleton design constructor
     */
    private function __construct()
    {
        // load default config
        self::$app = new \Slim\App(\Core\Config::get());
    }

    /**
     * get single instance
     *
     * @return \Core\Start
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $s = __CLASS__;
            $instance = new $s;
        }

        return self::$instance;
    }

    /**
     * get Slim instance
     *
     * @return \Slim\App
     */
    public static function getApp()
    {
        if (!isset(self::$app)) {
            self::getInstance();
        }

        return self::$app;
    }

    /**
     * run Slim
     *
     * @return void
     */
    public static function run()
    {
        self::$app->run();
    }

}
