<?php


namespace Validator\Rule;


use Validator\Rule;

class IsInteger extends AbtractImpl
{


    public function validate($value)
    {
        return is_integer($value);
    }


}