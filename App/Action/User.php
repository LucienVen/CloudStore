<?php

namespace App\Action;

class User extends \Core\Action
{
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

    /**
     * get user info.
     *
     * @return Response
     */
    public function info()
    {
        try {
            // check is the root user
            if (empty($this->_args['id'])) {
                if (!(int) $this->_container->get('jwt')['logInAs']) {
                    // don't have root
                    throw new \Exception('Permissions Denied!', 400);
                } else {
                    $res = $this->_model->info();
                }
            } else {
                $res = $this->_model->info($this->_args['id']);
            }
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }
}
