<?php

namespace App\Model;

class Test extends \Core\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        $res = $this->from()->fetchAll();
        // return ["key" => "this is a data"];
        return $res;
    }
}
