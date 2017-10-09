<?php

namespace Core;

use Core\Config;
use Firebase\JWT\JWT;

class Model extends \FluentPDO
{
    protected $_jwt;

    public function __construct()
    {
        // 初始化FPDO
        parent::__construct(Config::get('db'));
        $this->setDefault();
        $this->setTime();
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
     * get default value.
     *
     * @return array
     */
    public function getDefault()
    {
        return $this->_default;
    }

    /**
     * get the fields.
     */
    private function setDefault()
    {
        if (isset($this->_default) && !empty($this->_default) && is_array($this->_default)) {
            foreach ($this->_default as $k => $v) {
                // if is not the field
                if (!in_array($k, $this->field)) {
                    unset($value[$k]);
                }
            }
        } else {
            $this->_default = [];
        }
    }

    /**
     * auto set the time.
     */
    private function setTime()
    {
        // set create time
        if (isset($this->_autoTime) && !empty($this->_autoTime) && in_array($this->_autoTime, $this->field)) {
            $this->_default[$this->_autoTime] = time();
        }
        // set update time
        if (isset($this->_autoUpdate) && !empty($this->_autoUpdate) && in_array($this->_autoUpdate, $this->field)) {
            $this->_default[$this->_autoUpdate] = time();
        }
    }
}
