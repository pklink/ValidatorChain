<?php


namespace Validator\Rule;


use Validator\Rule;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
abstract class AbstractLengthImpl extends AbtractImpl
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
     * @return boolean
     */
    public abstract function validate($value);

}