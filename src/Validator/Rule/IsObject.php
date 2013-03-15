<?php


namespace Validator\Rule;


use Validator\Rule;

class IsObject extends AbtractImpl
{


    public function validate($value)
    {
        return is_object($value);
    }


}