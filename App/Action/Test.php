<?php

namespace App\Action;
use Firebase\JWT\JWT;

class Test extends \Core\Action
{
    public function __construct($c)
    {
        parent::__construct($c);
    }

    public function info()
    {
        $token = $this->_container['cookie']->get('token');
        $jwt = (array) JWT::decode($token, \Core\Config::get('secret'), array('HS256'));
        return $this->success($jwt);
    }

    public function test()
    {
        $testModel = new \App\Model\Test;
        // var_dump($this->_args);
        // echo "test<br>";
        $res = $testModel->test();
        return $this->success($res);
    }
}
