<?php


namespace Validator\Rule;


use Validator\Rule;

abstract class AbtractImpl implements Rule
{

    public function setOptions(array $options)
    {
        foreach ($options as $option => $value)
        {
            $setterName = sprintf('set%s', ucfirst($option));

            if (method_exists($this, $setterName))
            {
                $this->$setterName($value);
            }
        }
    }

}