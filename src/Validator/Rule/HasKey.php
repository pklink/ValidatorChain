<?php


namespace Validator\Rule;


use Validator\Rule;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
class HasKey extends AbtractImpl
{

    /**
     * @var string
     */
    public $key;


    /**
     * @param string|integer $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }


    /**
     * @param mixed $value
     * @return boolean
     */
    public function validate($value)
    {
        $isArray = new IsArray();
        return $isArray->validate($value) && is_scalar($this->key) && array_key_exists($this->key, $value);
    }


}