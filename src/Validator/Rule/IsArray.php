<?php


namespace Validator\Rule;


use Validator\Rule;

class IsArray extends AbtractImpl
{


    public function validate($value)
    {
        return is_array($value);
    }


}