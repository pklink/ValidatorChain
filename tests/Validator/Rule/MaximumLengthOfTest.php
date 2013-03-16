<?php


namespace Validator\Rule;

use Validator\Rule;

class MaximumLengthOfTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $instance = new MaximumLengthOf();
        $instance->setLength(3);
        $this->assertTrue($instance->validate(''));
        $this->assertTrue($instance->validate('bla'));
        $this->assertFalse($instance->validate('arra'));
        $this->assertFalse($instance->validate(123213));
        $this->assertFalse($instance->validate(-12131));
        $this->assertFalse($instance->validate(0x21F124));
        $this->assertFalse($instance->validate(new \stdClass()));
        $this->assertFalse($instance->validate(new \SplFixedArray(4)));
        $this->assertFalse($instance->validate(array()));
        $this->assertFalse($instance->validate([]));
        $this->assertFalse($instance->validate(null));
    }

}