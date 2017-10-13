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
        'default' => ['is_delete' => 0, 'status' => 1],
    ];

    public function __construct()
    {
        parent::__construct();
        // init validate
        $this->_validate = new Validate($this->_rules);
    }

    /**
     * login
     *
     * @param array $data
     * @return array
     */
    public function login($data)
    {
        // check
        $this->_validate->check($data);

        // find data in database
        $res['data'] = $this->from()->where('phone', $data['phone'])->fetch();
        // check password
        if (!password_verify($data['password'], $res['data']['password'])) {
            throw new \Exception('Username or Password Error!', 422);
        }
        $this->setJWT($res['data']['phone'], \Core\Config::get('jwt'), \Core\Config::get('secret'), 'Admin');
        unset($res['data']['password']);

        return $res;
    }

    /**
     * sign up
     *
     * @param array $data
     * @return array
     */
    public function signup($data)
    {
        // check and auto insert the time field
        $this->_validate->addRules([
            'autotime' => 'create_time',
            'autoupdate' => 'update_time'
        ])->check($data);

        // password encry
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        // add default username
        $data['username'] = 'cloud_'.$data['phone'];

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
}
