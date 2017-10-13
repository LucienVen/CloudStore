<?php

namespace App\Model;

use Core\Validate;

class User extends \Core\Model
{
    // validate config
    private $_validate;
    private $_rules = [
        'require' => ['phone', 'password'],
        'length' => ['phone' => '11', 'password' => '6,20'],
        'default' => ['is_root' => 0, 'is_delete' => 0, 'status' => 1],
    ];

    private $_prefixName = 'cloud_';

    public function __construct()
    {
        parent::__construct();
        // init validate
        $this->_validate = new Validate($this->_rules);
    }

    /**
     * login.
     *
     * @param array $data
     *
     * @return array
     */
    public function login($data)
    {
        // check
        $this->_validate->check($data);

        // find data in database
        $res = $this->from()->where('phone', $data['phone'])->fetch();
        // check password
        if (!password_verify($data['password'], $res['password'])) {
            throw new \Exception('Username or Password Error!', 422);
        }
        // set jwt token
        $this->setJWT($res['phone'], \Core\Config::get('jwt'), \Core\Config::get('secret'), $res['is_root']);
        unset($res['password']);

        return $res;
    }

    /**
     * sign up.
     *
     * @param array $data
     *
     * @return array
     */
    public function signup($data)
    {
        // invalide sign up the root user
        unset($data['is_root']);

        // check and auto insert the time field
        $this->_validate->addRules([
            'autotime' => 'create_time',
            'autoupdate' => 'update_time',
        ])->check($data);

        // password encry
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        // add default username
        $data['username'] = $this->_prefixName.$data['phone'];

        // phone number exitis check
        if ($this->from()->where('phone', $data['phone'])->fetch()) {
            throw new \Exception('Phone has been Signed!', 422);
        }

        // insert and filter value
        if ($res = $this->insertInto()->field()->values($data)->execute()) {
            // get the new user info
            $newuser = $this->from()->where('id', $res)->fetch();
            unset($newuser['password']);

            return $newuser;
        }

        throw new \Exception('Error!', 422);
    }

    /**
     * get user info.
     *
     * @param int $id
     *
     * @return array
     */
    public function info($id = null)
    {
        // get all user info
        if (is_null($id)) {
            if ($res = $this->from()
                        ->select(null)
                        ->select(['id', 'phone', 'username'])
                        ->limit(10)->fetchAll()) {
                return $res;
            }
        }

        // get special user info
        if ($res = $this->from()
                    ->where('id', $id)
                    ->select(null)
                    ->select(['id', 'phone', 'username'])
                    ->fetch()) {
            return $res;
        }

        throw new \Exception("User Don't Exist!", 404);
    }
}
