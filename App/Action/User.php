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
        $data = $this->_request->getParsedBody();
        try {
            $res = $this->_model->login($data);
        } catch (\Exception $e) {
            return $this->error(
                $e->getCode(),
                empty($e->getMessage()) ? $this->_ERR_MSG[$e->getCode()] : $e->getMessage()
            );
        }

        $this->cookie($this->_container['newcookie'], ['token' => $this->_model->getJWT()]);
        return $this->success($res);
    }

    public function signup()
    {
        $data = $this->_request->getParsedBody();
        try {
            $res = $this->_model->signup($data);
        } catch (\Exception $e) {
            return $this->error(
                $e->getCode(),
                empty($e->getMessage()) ? $this->_ERR_MSG[$e->getCode()] : $e->getMessage()
            );
        }

        return $this->success($res);
    }
}
