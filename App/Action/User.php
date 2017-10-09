<?php

namespace App\Action;

use App\Model\User as UserModel;

class User extends \Core\Action
{
    public function __construct($c)
    {
        parent::__construct($c);
    }

    public function login()
    {
        $data = $this->_request->getQueryParams();
        try {
            $user = new UserModel();
            $res = $user->login($data);
            var_dump($res);
        } catch (\Exception $e) {
        }
    }

    public function signup()
    {
        $data = $this->_request->getParsedBody();
        try {
            $user = new UserModel();
            $res = $user->signup($data);
            var_dump($res);
        } catch (\Exception $e) {
        }
    }
}
