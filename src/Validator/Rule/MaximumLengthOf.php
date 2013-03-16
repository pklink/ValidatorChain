<?php


namespace Validator\Rule;


use Validator\Rule;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
class MaximumLengthOf extends AbtractImpl
{

    /**
     * @var integer
     */
    protected $length = 0;


    /**
     * @param integer $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }


    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value)
    {
        $stringValidator = new IsString();
        return $stringValidator->validate($value) && strlen($value) <= $this->length;
    }

}