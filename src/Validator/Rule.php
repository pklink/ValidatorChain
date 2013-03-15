<?php


namespace Validator;


interface Rule
{

    public function setOptions(array $options);

    public function validate($value);

}