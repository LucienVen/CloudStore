<?php

namespace App\Action;

class User extends \Core\Action
{
    public function __construct($c)
    {
        parent::__construct($c);
    }

    /**
     * login action.
     *
     * @return Response
     */
    public function login()
    {
        // get data
        $data = $this->_request->getParsedBody();
        try {
            $res = $this->_model->login($data);
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        // set token in cookie
        $this->cookie($this->_container['newcookie'], ['token' => $this->_model->getJWT()]);

        return $this->success($res);
    }

    /**
     * sign up action.
     *
     * @return Response
     */
    public function signup()
    {
        $data = $this->_request->getParsedBody();
        try {
            $res = $this->_model->signup($data);
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
