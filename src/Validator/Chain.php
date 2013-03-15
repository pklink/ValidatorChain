<?php


namespace Validator;


use Validator\Rule\IsArray;
use Validator\Rule\IsInteger;
use Validator\Rule\IsObject;
use Validator\Rule\IsString;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
class Chain
{

    /**
     * @var mixed
     */
    protected $value;


    /**
     * @var boolean
     */
    protected $isValid = true;


    /**
     * @param mixed $value
     */
    function __construct($value)
    {
        $this->value = $value;
    }


    /**
     * @return Chain
     */
    public function isArray()
    {
        $rule = new IsArray();
        $this->setIsValid( $rule->validate($this->value) );
        return $this;
    }


    /**
     * Alias for Chain::isInteger()
     *
     * @return Chain
     */
    public function isInt()
    {
        return $this->isInteger();
    }


    /**
     * @return Chain
     */
    public function isInteger()
    {
        $rule = new IsInteger();
        $this->setIsValid( $rule->validate($this->value) );
        return $this;
    }


    /**
     * @return Chain
     */
    public function isObject()
    {
        $rule = new IsObject();
        $this->setIsValid( $rule->validate($this->value) );
        return $this;
    }


    /**
     * @return Chain
     */
    public function isString()
    {
        $rule = new IsString();
        $this->setIsValid( $rule->validate($this->value) );
        return $this;
    }


    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->isValid;
    }


    /**
     * @return Chain
     */
    public function reset()
    {
        $this->isValid = true;
        return $this;
    }


    /**
     * @param mixed $value
     */
    protected function setIsValid($value)
    {
        if ($this->isValid)
        {
            $this->isValid = $value;
        }
    }

}