<?php


namespace Validator;


use Validator\Rule\IsArray;
use Validator\Rule\IsString;

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