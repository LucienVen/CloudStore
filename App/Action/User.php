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
        try {
            $res = $this->_model->login($this->_request->getParsedBody());
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        // set token in cookie
        $this->cookie($this->_container['newcookie'], ['token' => $this->_model->getJWT()]);

        return $this->success($res);
    }

    /**
     * log out.
     *
     * @return Response
     */
    public function logout()
    {
        $this->cookie($this->_container['newcookie'], ['token' => '']);

        return $this->success('log out success!');
    }

    /**
     * sign up action.
     *
     * @return Response
     */
    public function signup()
    {
        try {
            $res = $this->_model->signup($this->_request->getParsedBody());
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
                    $res = $this->_model->allInfo();
                }
            } else {
                $res = $this->_model->info($this->_args['id']);
            }
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * update user info
     *
     * @return Response
     */
    public function update()
    {
        try {
            // log in as Admin
            if (!(int) $this->_container->get('jwt')['logInAs']) {
                // want to chnage another user
                if ($this->_container->get('jwt')['aud'] != $this->_args['id']) {
                    return $this->error(422, "Permission Denied!");
                }
            }
            $res = $this->_model->updateInfo($this->_args['id'], $this->_request->getParsedBody());
        } catch (\Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($res);
    }

    /**
     * check user has been loged.
     *
     * @param Request  $request
     * @param Response $response
     * @param callback $next
     *
     * @return Response
     */
    public function checkToken($request, $response, $next)
    {
        if ($jwt = $this->_container->get('jwt')) {
            try {
                if ($jwt['iss'] == \Core\Config::get('iss')) {
                    if ($jwt['exp'] > time()) {
                        $this->_model->info($jwt['aud']);

                        return $next($request, $response);
                    }
                }
            } catch (\Exception $e) {
                return $this->error($e->getCode(), $e->getMessage());
            }
        }

        return $this->error(404, 'Login First, Please!');
    }
}
