<?php

namespace App\Model;

use \Core\Validate;

class Address extends \Core\Model
{
    protected $_rules = [
        'require' => ['name', 'address', 'phone'],
        'length' => ['phone' => '11']
    ];

    /**
     * get address info
     *
     * @param int $uid
     * @return array
     */
    public function info($uid)
    {
        $query = $this->from()->where(['uid' => $uid, 'is_delete' => 0]);
        $res['all'] = $query->count();
        if ($res['data'] = $query->fetchAll()) {
            return $res;
        }

        throw new Exception("Address Dont't Exist!", 404);
    }

    /**
     * add address
     *
     * @param int $uid
     * @param array $data
     * @return array
     */
    public function add($uid, $data)
    {
        $this->_validate->addRules([
            'default' => ['is_delete' => 0, 'status' => 1, 'uid' => $uid],
            'autotime' => 'create_time',
            'autoupdate' => 'update_time'
        ])->check($data);

        // init the default address
        if (!$this->from()->where(['uid' => $uid, 'is_delete' => 0])->count()) {
            $data['is_default'] = 1;
        }

        if ($res = $this->insertInto()->field()->values($data)->execute()){
            $info = $this->from()->where('id', $res)->fetch();
            return $info;
        }

        throw new Exception("Add Error!", 500);
    }

    /**
     * update address info
     *
     * @param int $address_id
     * @param array $data
     * @return array
     */
    public function updateInfo($address_id, $data)
    {
        $this->_validate->check($data, [
            'length' => ['phone' => '11'],
            'autoupdate' => 'update_time'
        ]);

        if ($this->update()->set($data)->where(['id' => $address_id, 'is_delete' => 0])->execute()) {
            return $this->from()->where(['id' => $address_id, 'is_delete' => 0])->fetch();
        }

        throw new Exception("Update Error!", 500);
    }

    /**
     * fake delete address info
     *
     * @param [type] $address_id
     * @return void
     */
    public function deleteInfo($address_id)
    {
        if ($this->update()->set(['is_delete' => 1])->where(['id' => $address_id, 'is_delete' => 0])->execute()) {
            return "Delete Success!";
        }

        throw new Exception("Delete Error!", 500);
    }
}
