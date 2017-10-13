<?php

namespace Core;

use Firebase\JWT\JWT;

class Model extends \FluentPDO
{
    protected $_jwt;

    public function __construct()
    {
        // 初始化FPDO
        parent::__construct(Config::get('db'));
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
}
