<?php

namespace Core;

use Firebase\JWT\JWT;

class Model extends \FluentPDO
{
    /**
     * jwt
     *
     * @var string
     */
    protected $_jwt;

    /**
     * validate
     *
     * @var \Core\Validate
     */
    protected $_validate;

    /**
     * default rules
     *
     * @var [type]
     */
    protected $_rules = [];

    public function __construct()
    {
        // 初始化FPDO
        parent::__construct(Config::get('db'));
        $this->_validate = new \Core\Validate($this->_rules);
    }

    /**
     * get JWT token.
     *
     * @return string
     */
    public function getJWT()
    {
        return $this->_jwt;
    }

    /**
     * set JWT's format.
     *
     * @param string $aud
     * @param string $token
     * @param string $key
     * @param string $root
     */
    protected function SetJWT($aud, $token, $key, $root)
    {
        $token = array_merge($token, [
            'iat' => $_SERVER['REQUEST_TIME'],
            'exp' => $_SERVER['REQUEST_TIME'] + 604800,
            'aud' => $aud,
            'logInAs' => $root,
        ]);

        $this->_jwt = JWT::encode($token, $key);
    }

    /**
     * add prefix to data key
     *
     * @param array $data
     * @param string $thisTable
     * @param string $joinTable
     * @return array
     */
    protected function tablePrefix($data, $thisTable, $joinTable)
    {
        foreach ($data as $key => $value) {
            // search key in table's field
            foreach ($this->getField() as $field) {
                // key in table
                if ($field == $key) {
                    // add prefix
                    unset($data[$key]);
                    $key = $thisTable.'.'.$key;
                    $data[$key] = $value;
                    break;
                }
            }
            // in another table
            if (!strpos($key, '.')) {
                unset($data[$key]);
                $key = $joinTable.'.'.$key;
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
