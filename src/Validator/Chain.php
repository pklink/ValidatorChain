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
     * @var boolean
     */
    protected $isValid = true;


    /**
     * @var \Closure[]
     */
    protected $onValidationFailedListener = [];


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
    function __construct($value, array $options = [])
    {
        $options = new Dotor($options);
        $this->throwExceptionOnFailure = $options->getBoolean('throwExceptionOnFailure', false);
        $this->stopValidationOnFailure = $options->getBoolean('stopValidationOnFailure', true);

        // throwExceptionOnFailure
        if ($this->throwExceptionOnFailure)
        {
            $this->addOnValidationFailedListener(function() {
                $this->validationFailedExceptionListener();
            });
        }

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
            return new Rule\IsArray();
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
            return new Rule\IsInteger();
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isNull()
    {
        $this->run(function() {
            return new Rule\IsNull();
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isNumeric()
    {
        $this->run(function() {
            return new Rule\IsNumeric();
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isObject()
    {
        $this->run(function() {
            return new Rule\IsObject();
        });

        return $this;
    }


    /**
     * @return Chain
     */
    public function isString()
    {
        $this->run(function() {
            return new Rule\IsString();
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
        if ($this->isValid() || !$this->stopValidationOnFailure)
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


    /**
     * @param bool $value
     * @throws \InvalidArgumentException
     */
    public function stopValidationOnFailure($value = true)
    {
        if (!is_bool($value))
        {
            throw new \InvalidArgumentException();
        }

        $this->stopValidationOnFailure = $value;
    }


    /**
     * @throws Exception
     */
    protected function validationFailedExceptionListener()
    {
        throw new Exception();
    }

}