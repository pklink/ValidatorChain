<?php


namespace Validator\Rule;


use Validator\Rule;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
class MinimumLengthOf extends AbstractLengthImpl
{

    /**
     * @param mixed $value
     * @return boolean
     */
    public function validate($value)
    {
        $stringValidator = new IsString();
        return $stringValidator->validate($value) && strlen($value) >= $this->length;
    }

}