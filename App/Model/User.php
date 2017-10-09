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
                $res = $this->from()->where('phone', $data['phone'])->fetch();
                if (password_verify($data['password'], $res['password'])) {
                    return $res;
                }
            }
        }
    }

    public function signup($data)
    {
        if (isset($data['phone']) && !is_null($data['phone'])) {
            if (isset($data['username']) && !is_null($data['username'])) {
                if (isset($data['password']) && !is_null($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $res = $this->insertInto('', $data)->execute();
                    return $res;
                }
            }
        }
    }
}
