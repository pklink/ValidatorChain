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
     * @var boolean
     */
    protected $isValid = true;


    /**
     * @var \Closure[]
     */
    protected $onValidationFailedListener = [];


    /**
     * @var mixed
     */
    protected $value;


    /**
     * @param mixed $value
     */
    function __construct($value)
    {
        $this->value = $value;
    }


    /**
     * @param callable $listener
     */
    public function addOnValidationFailedListener(\Closure $listener)
    {
        $this->onValidationFailedListener[] = $listener;
    }


    /**
     * @return Chain
     */
    public function isArray()
    {
        $this->run(function() {
            return new IsArray();
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
            return new IsInteger();
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isNull()
    {
        $this->run(function() {
            return new IsNull();
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isNumeric()
    {
        $this->run(function() {
            return new IsNumeric();
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isObject()
    {
        $this->run(function() {
            return new IsObject();
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isString()
    {
        $this->run(function() {
            return new IsString();
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
     * @param Rule $rule
     */
    protected function onValidationFailed(Rule $rule)
    {
        // call all listender
        foreach ($this->onValidationFailedListener as $listener)
        {
            $listener($rule);
        }
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
     * @param callable $callable need to return an instance of Rule
     * @throws \RuntimeException
     */
    protected function run(\Closure $callable)
    {
        if ($this->isValid())
        {
            /* @var Rule $rule */
            $rule = $callable();

            // check if $rule an instace of Rule
            if (!($rule instanceof Rule))
            {
                throw new \RuntimeException('$callable need to return an inastance of Validator\Rule');
            }

            // validation
            $this->setIsValid( $rule->validate($this->value) );

            // if validation failed run the OnValidationFailed-Event
            if (!$this->isValid())
            {
                $this->onValidationFailed($rule);
            }
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