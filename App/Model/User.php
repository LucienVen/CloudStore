<?php

namespace App\Model;

class User extends \Core\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($data)
    {
        if (isset($data['phone']) && !is_null($data['phone'])) {
            if (isset($data['password']) && !is_null($data['password'])) {
                $res['data'] = $this->from()->where('phone', $data['phone'])->fetch();
                if (password_verify($data['password'], $res['data']['password'])) {
                    unset($res['data']['password']);
                    $this->setJWT($res['data']['phone'], \Core\Config::get('jwt'), \Core\Config::get('secret'), "Admin");

                    return $res;
                }
                throw new \Exception('Username or Password Error!', 422);
            }
        }
        throw new \Exception('Data Invalidate!', 422);
    }

    public function signup($data)
    {
        if (isset($data['phone']) && !is_null($data['phone'])) {
            if (isset($data['password']) && !is_null($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $res = $this->insertInto('', $data)->execute();
                if (0 != $res) {
                    unset($res['data']['password']);

                    return $res;
                }
            }
        }
        throw new \Exception('Data Invalidate!', 422);
    }
}
