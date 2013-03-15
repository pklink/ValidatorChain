<?php


namespace Validator;


use Validator\Rule\IsArray;
use Validator\Rule\IsInteger;
use Validator\Rule\IsNull;
use Validator\Rule\IsNumeric;
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
        $this->run(function() {
            $rule = new IsArray();
            $this->setIsValid( $rule->validate($this->value) );
        });

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
        $this->run(function() {
            $rule = new IsInteger();
            $this->setIsValid( $rule->validate($this->value) );
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isNull()
    {
        $this->run(function() {
            $rule = new IsNull();
            $this->setIsValid( $rule->validate($this->value) );
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isNumeric()
    {
        $this->run(function() {
            $rule = new IsNumeric();
            $this->setIsValid( $rule->validate($this->value) );
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isObject()
    {
        $this->run(function() {
            $rule = new IsObject();
            $this->setIsValid( $rule->validate($this->value) );
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isString()
    {
        $this->run(function() {
            $rule = new IsString();
            $this->setIsValid( $rule->validate($this->value) );
        });

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
     * @param callable $callable
     */
    protected function run(\Closure $callable)
    {
        if ($this->isValid())
        {
            $callable();
        }
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