<?php


namespace Validator;


use Dotor\Dotor;

/**
 * Available options:
 *  'throwExceptionOnFailure' => will throw a \Validator\Exception if a validation has failed (default: false)
 *  'stopValidationOnFailure' => will not perform any validation after a failure (default: true)
 *
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
class Chain
{

    /**
     * @var Rule[]
     */
    private $failures = [];


    /**
     * @var boolean
     */
    private $isValid = true;


    /**
     * @var \Closure[]
     */
    protected $validationFailureListener = [];


    /**
     * @var boolean
     */
    protected $stopValidationOnFailure = true;


    /**
     * @var boolean
     */
    protected $throwExceptionOnFailure = false;


    /**
     * @var mixed
     */
    protected $value;


    /**
     * @param mixed $value
     * @param array $options
     */
    public function __construct($value, array $options = [])
    {
        $options = new Dotor($options);
        $this->throwExceptionOnFailure = $options->getBoolean('throwExceptionOnFailure', false);
        $this->stopValidationOnFailure = $options->getBoolean('stopValidationOnFailure', true);

        $this->value = $value;
    }


    /**
     * @param Rule $rule
     */
    protected function addFailure(Rule $rule)
    {
        $this->failures[] = $rule;
    }


    /**
     * @param \Closure $listener
     */
    public function addValidationFailureListener(\Closure $listener)
    {
        $this->validationFailureListener[] = $listener;
    }


    /**
     * @return Rule[]
     */
    public function getFailures()
    {
        return $this->failures;
    }


    /**
     * @param string|integer $key
     * @return Chain
     */
    public function hasKey($key)
    {
        if (!$this->isBroken())
        {
            $this->validate(new Rule\HasKey(['key' => $key]));
        }

        return $this;
    }


    /**
     * @param array $keys
     * @return $this
     */
    public function hasKeys(array $keys)
    {
        if (!$this->isBroken())
        {
            $this->validate(new Rule\HasKeys(['keys' => $keys]));
        }

        return $this;
    }


    /**
     * @return Chain
     */
    public function isArray()
    {
        if (!$this->isBroken())
        {
            $this->validate(new Rule\IsArray());
        }

        return $this;
    }


    /**
     * @return boolean
     */
    protected function isBroken()
    {
        return !$this->isValid() && $this->stopValidationOnFailure;
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
        if (!$this->isBroken())
        {
            $this->validate(new Rule\IsInteger());
        }

        return $this;
    }


    /**
     * @return Chain
     */
    public function isNull()
    {
        if (!$this->isBroken())
        {
            $this->validate(new Rule\IsNull());
        }

        return $this;
    }


    /**
     * @return Chain
     */
    public function isNumeric()
    {
        if (!$this->isBroken())
        {
            $this->validate(new Rule\IsNumeric());
        }

        return $this;
    }


    /**
     * @return Chain
     */
    public function isObject()
    {
        if (!$this->isBroken())
        {
            $this->validate(new Rule\IsObject());
        }

        return $this;
    }


    /**
     * @return Chain
     */
    public function isScalar()
    {
        if (!$this->isBroken())
        {
            $this->validate(new Rule\IsScalar());
        }

        return $this;
    }


    /**
     * @return Chain
     */
    public function isString()
    {
        if (!$this->isBroken())
        {
            $this->validate(new Rule\IsString());
        }

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
     * @param integer $length
     * @return Chain
     */
    public function lengthOf($length)
    {
        if (!$this->isBroken())
        {
            $rule = new Rule\LengthOf(['length' => $length]);
            $this->validate($rule);
        }

        return $this;
    }


    /**
     * @param integer $length
     * @return Chain
     */
    public function maximumLengthOf($length)
    {
        if (!$this->isBroken())
        {
            $rule = new Rule\MaximumLengthOf(['length' => $length]);
            $this->validate($rule);
        }

        return $this;
    }


    /**
     * @param integer $length
     * @return Chain
     */
    public function minimumLengthOf($length)
    {
        if (!$this->isBroken())
        {
            $rule = new Rule\MinimumLengthOf(['length' => $length]);
            $this->validate($rule);
        }

        return $this;
    }


    /**
     * @param Rule $rule
     * @throws Exception
     */
    protected function notifyAllOnValidationFailureListener(Rule $rule)
    {
        // call all listener
        foreach ($this->validationFailureListener as $listener)
        {
            $listener($rule);
        }

        if ($this->throwExceptionOnFailure)
        {
            throw new Exception();
        }
    }


    /**
     * @return Chain
     */
    public function reset()
    {
        $this->isValid  = true;
        $this->failures = [];
        return $this;
    }


    /**
     * $value will only be set if $this->isValid == true
     *
     * @param mixed $value
     */
    protected function setIsValid($value)
    {
        if ($this->isValid)
        {
            $this->isValid = $value;
        }
    }


    /**
     * @param boolean $value
     * @return Chain
     * @throws \InvalidArgumentException
     */
    public function stopValidationOnFailure($value = true)
    {
        if (!is_bool($value))
        {
            throw new \InvalidArgumentException();
        }

        $this->stopValidationOnFailure = $value;
        return $this;
    }


    /**
     * @param boolean $value
     * @return Chain
     * @throws \InvalidArgumentException
     */
    public function throwExceptionOnFailure($value = true)
    {
        if (!is_bool($value))
        {
            throw new \InvalidArgumentException();
        }

        $this->throwExceptionOnFailure = $value;
        return $this;
    }


    /**
     * @param Rule $rule
     */
    protected function validate(Rule $rule)
    {
        // run test only if chain is not broken
        if (!$this->isBroken())
        {
            // validate
            $isValid = $rule->validate($this->value);
            $this->setIsValid($isValid);

            // if validation failed run the OnValidationFailed-Event and save rule
            if (!$isValid)
            {
                $this->addFailure($rule);
                $this->notifyAllOnValidationFailureListener($rule);
            }
        }
    }

}