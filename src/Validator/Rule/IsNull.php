<?php


namespace Validator\Rule;


use Validator\Rule;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
class IsNull extends AbtractImpl
{


    public function validate($value)
    {
        return is_null($value);
    }


}