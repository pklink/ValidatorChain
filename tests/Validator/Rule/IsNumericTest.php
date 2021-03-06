<?php


namespace Validator\Rule;

use Validator\Rule;

class IsNumericTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $instance = new IsNumeric();
        $this->assertFalse($instance->validate(''));
        $this->assertFalse($instance->validate('bla'));
        $this->assertFalse($instance->validate('array'));
        $this->assertTrue($instance->validate('123'));
        $this->assertTrue($instance->validate(123213));
        $this->assertTrue($instance->validate(-12131));
        $this->assertTrue($instance->validate(0x21F124));
        $this->assertFalse($instance->validate(new \stdClass()));
        $this->assertFalse($instance->validate(new \SplFixedArray(4)));
        $this->assertFalse($instance->validate(array()));
        $this->assertFalse($instance->validate([]));
        $this->assertFalse($instance->validate(null));
    }

}