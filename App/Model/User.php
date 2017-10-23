<?php

namespace App\Model;

use Core\Validate;

class User extends \Core\Model
{
    // validate config
    protected $_rules = [
        'require' => ['phone', 'password'],
        'length' => ['phone' => '11', 'password' => '6,20'],
        'default' => ['is_root' => 0, 'is_delete' => 0, 'status' => 1],
    ];

    private $_prefixName = 'cloud_';

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
        if ($res = $this->from()->where(['phone' => $data['phone'], 'is_delete' => 0])->fetch()) {
            // check password
            if (!password_verify($data['password'], $res['password'])) {
                throw new \Exception('Username or Password Error!', 422);
            }
            // set jwt token
            $this->setJWT($res['id'], \Core\Config::get('jwt'), \Core\Config::get('secret'), $res['is_root']);
            unset($res['password']);

            return $res;
        }

        throw new \Exception('Username or Password Error!', 422);
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
            'require' => ['password_again'],
            'passcheck' => ['password', 'password_agian'],
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
            // create user default detail
            $this->insertInto('user_detail', ['uid' => $res])->execute();
            // get the new user info
            $newuser = $this->info($res);

            return $newuser;
        }

        throw new \Exception('Error!', 422);
    }

    /**
     * get all user info.
     *
     * @param int $page
     * @param int $offset
     *
     * @return Response
     */
    public function allInfo($page = 1, $offset = 10)
    {
        $res['page'] = $page;
        $res['all'] = $this->from()->count();
        // get all user info
        if ($res['data'] = $this->from()
                    ->leftJoin('user_detail ON user.id = user_detail.uid')
                    ->where('is_delete', 0)
                    ->select(null)
                    ->select(['user.id', 'user.phone', 'user.username', 'user_detail.email'])
                    ->limit($offset)
                    ->offset(($page - 1) * $offset)
                    ->fetchAll()) {
            return $res;
        }
    }

    /**
     * get user info.
     *
     * @param int $id
     *
     * @return array
     */
    public function info($id)
    {
        // get special user info
        if ($res = $this->from()
                    ->leftJoin('user_detail ON user.id = user_detail.uid')
                    ->where(['user.id' => $id, 'user.is_delete' => 0])
                    ->select(null)
                    ->select(['user.id', 'user.phone', 'user.username', 'user_detail.email', 'user_detail.avater_id'])
                    ->fetch()) {
            $res = array_merge($res, $this->from('media')
                                ->where(['id' => $res['avater_id']])
                                ->select(null)
                                ->select('url_path as avater')
                                ->fetch());
            unset($res['avater_id']);
            return $res;
        }

        throw new \Exception("User Don't Exist!", 404);
    }

    /**
     * update user info.
     *
     * @param int   $id
     * @param array $data
     *
     * @return array
     */
    public function updateInfo($id, $data)
    {
        $this->_validate->check($data, [
            'length' => ['username' => '4,30', 'phone' => '11'],
            'email' => ['email'],
            'autoupdate' => 'update_time',
        ]);

        // check phone number
        if (isset($data['phone'])) {
            if ($this->from()->where(['phone' => $data['phone'], 'is_delete' => 0])->count()) {
                throw new \Exception("Phone Number Has Exist!", 422);
            }
        }

        // join table name
        $join = 'user_detail';
        // add table prefix for join table
        $data = $this->tablePrefix($data, $this->table, $join);

        if ($res = $this->update()
                    ->leftJoin($join.' ON user.id = '.$join.'.uid')
                    ->set($data)
                    ->where('user.id', $id)
                    ->execute()) {
            // get updated user info
            $updateUser = $this->info($id);

            return $updateUser;
        }

        throw new \Exception("Update Error!", 422);
    }
}
