<?php

namespace Core;

class Validate
{
    /** @var array */
    private $_rules;

    public function __construct($rules = array())
    {
        // default rule
        $this->_rules = $rules;
    }

    /**
     * add rule to validate.
     *
     * @param array $rules
     *
     * @return Validate
     */
    public function addRules(array $rules)
    {
        // merge default value
        foreach ($rules as $key => $value) {
            if ('autotime' == $key || 'autoupdate' == $key) {
                $this->_rules[$key] = $value;
                continue;
            }
            if (array_key_exists($key, $this->_rules)) {
                array_merge($this->_rules[$key], $value);
            } else {
                $this->_rules = array_merge($this->_rules, $rules);
            }
        }

        return $this;
    }

    /**
     * reset default rules.
     *
     * @param array $rules
     *
     * @return Validate
     */
    public function resetRules($rules)
    {
        $this->_rules = $rules;

        return $this;
    }

    /**
     * check data by rule.
     *
     * @param array $data
     * @param array $rules temporary rules
     */
    public function check(&$data, $rules = array())
    {
        if (empty($rules) || is_null($rules)) {
            $rules = $this->_rules;
        }
        // search rule's function
        foreach ($rules as $key => $value) {
            // insert default fields
            if ('default' == $key) {
                $data = array_merge($value, $data);
                continue;
            }
            // insert the create time or update time
            if ('autotime' == $key || 'autoupdate' == $key) {
                $data = array_merge([$value => time()], $data);
                continue;
            }
            // call the rules function
            if (!$this->{$key}($value, $data)) {
                throw new \Exception(implode(' or ', array_keys($value)).' '.$key.': field error!', 422);
            }
        }
    }

    /**
     * require check.
     *
     * @param array $rule
     * @param array $data
     *
     * @return bool
     */
    private function require($rule, $data)
    {
        foreach ($rule as $value) {
            if (!array_key_exists($value, $data)) {
                return false;
            }
        }

        return true;
    }

    /**
     * password check.
     *
     * @param array $rule
     * @param array $data
     *
     * @return bool
     */
    private function passcheck($rule, $data)
    {
        if (array_key_exists($rule[0], $data) && array_key_exists($rule[1], $data)) {
            if ($data[$rule[0]] !== $data[$rule[1]]) {
                return false;
            }
        }

        return true;
    }

    /**
     * length check.
     *
     * @param array $rule
     * @param array $data
     *
     * @return bool
     */
    private function length($rule, $data)
    {
        foreach ($rule as $key => $value) {
            if (array_key_exists($key, $data)) {
                // the number that value between with
                $bwt = explode(',', $value, 2);
                // data's value
                $len = $data[$key];
                // string's length
                if (is_string($data[$key])) {
                    $len = strlen($data[$key]);
                }
                // provision the fixed length
                if (1 == count($bwt)) {
                    if ($len != $bwt[0]) {
                        return false;
                    }
                    // provision the scope of length
                } elseif ($len < (int) $bwt[0] || $len > (int) $bwt[1]) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * field has choose value
     *
     * @param array $rule
     * @param array $data
     * @return boolean
     */
    private function choose($rule, $data)
    {
        foreach ($rule as $key => $value) {
            if (array_key_exists($key, $data)) {
                $vs = explode(',', $value);
                $flag = 0;
                foreach ($v as $vs) {
                    $flag = ''.$data[$key] == $v ? 1 : $flag;
                }
                if (!$flag) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * email check.
     *
     * @param array $rule
     * @param array $data
     *
     * @return bool
     */
    private function email($rule, $data)
    {
        foreach ($rule as $value) {
            if (array_key_exists($value, $data)) {
                if (false === filter_var($data[$value], FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * two field depend on each other
     *
     * @param array $rule
     * @param array $data
     * @return boolean
     */
    private function depend($rule, $data)
    {
        foreach ($rule as $key => $value) {
            if (array_key_exists($key, $data)) {
                if (array_key_exists($value, $data)) {
                    continue;
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * call undefine function.
     *
     * @param string $name
     * @param array  $arguments
     */
    public function __call($name, $arguments)
    {
        throw new \Exception('call undefine function : '.$name, 500);
    }

    /**
     * init the rules
     *
     * @param array $rules
     */
    public function __invoke($rules)
    {
        $this->_rules = $rules;
    }
}
