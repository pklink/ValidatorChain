<?php


namespace Validator\Rule;


use Validator\Rule;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
abstract class AbtractImpl implements Rule
{

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }


    /**
     * @param array $options
     */
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