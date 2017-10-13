<?php

namespace App\Model;

use Core\Validate;

class Test extends \Core\Model
{
    private $_validate;
    public $_rules = [
        'require' => ['phone', 'password'],
        'length' => ['phone' => '11', 'password' => '6,20'],
        'default' => ['is_delete' => 0, 'status' => 1],
        'autotime' => 'create_time',
        'autoupdate' => 'update_time',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->_validate = new Validate($this->_rules);
    }

    public function test($data)
    {
        $this->_validate->check($data);
        $res = $this->from()->fetchAll();
        // return ["key" => "this is a data"];
        return $data;
    }
}
