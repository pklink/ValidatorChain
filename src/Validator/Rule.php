<?php


namespace Validator;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
interface Rule
{

    /**
     * @param array $options
     * @return void
     */
    public function setOptions(array $options);

    /**
     * @param mixed $value
     * @return boolean
     */
    public function validate($value);

}