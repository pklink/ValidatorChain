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
        $key      = $this->key;
        $isScalar = new IsScalar();
        $isArray  = new IsArray();

        return $isArray->validate($value) && $isScalar->validate($key) && array_key_exists($this->key, $value);
    }

}