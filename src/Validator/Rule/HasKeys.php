<?php


namespace Validator\Rule;


use Validator\Rule;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
class HasKeys extends AbtractImpl
{

    /**
     * @var array
     */
    public $keys;


    /**
     * @param array $keys
     */
    public function setKeys(array $keys)
    {
        $this->keys = $keys;
    }


    /**
     * @param mixed $value
     * @return boolean
     */
    public function validate($value)
    {
        $keys   = $this->keys;
        $hasKey = new HasKey();

        foreach ($keys as $key)
        {
            $hasKey->setKey($key);
            if (!$hasKey->validate($value))
            {
                return false;
            }
        }

        return true;
    }

}