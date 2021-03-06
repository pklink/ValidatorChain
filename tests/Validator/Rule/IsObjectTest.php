<?php


namespace Validator\Rule;

use Validator\Rule;

class IsObjectTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $instance = new IsObject();
        $this->assertFalse($instance->validate(''));
        $this->assertFalse($instance->validate('bla'));
        $this->assertFalse($instance->validate('array'));
        $this->assertFalse($instance->validate(123213));
        $this->assertFalse($instance->validate(-12131));
        $this->assertFalse($instance->validate(0x21F124));
        $this->assertTrue($instance->validate(new \stdClass()));
        $this->assertTrue($instance->validate(new \SplFixedArray(4)));
        $this->assertFalse($instance->validate(array()));
        $this->assertFalse($instance->validate([]));
        $this->assertFalse($instance->validate(null));
    }

}