<?php


namespace Validator\Rule;


use Validator\Rule;

class IsString extends AbtractImpl
{


    public function validate($value)
    {
        return is_string($value);
    }


}