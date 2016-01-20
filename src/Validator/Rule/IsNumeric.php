<?php


namespace Validator\Rule;


use Validator\Rule;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
class IsNumeric extends AbstractImpl
{

    /**
     * @param mixed $value
     * @return boolean
     */
    public function validate($value)
    {
        return is_numeric($value);
    }

}