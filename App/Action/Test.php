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
        try {
            $res = $this->_model->test($this->_request->getParsedBody());
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
