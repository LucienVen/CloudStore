<?php

namespace App\Action;

class Test extends \Core\Action
{
    public function __construct($c)
    {
        parent::__construct($c);
    }

    public function test()
    {
        $testModel = new \App\Model\Test;
        // var_dump($this->_args);
        // echo "test<br>";
        $res = $testModel->test();
        return $this->success($res);
    }
}
