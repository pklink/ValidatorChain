<?php


namespace Validator\Rule;

use Validator\Rule;

class HasKeyTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $instance = new HasKey(['key' => 'index']);
        $this->assertFalse($instance->validate(''));
        $this->assertFalse($instance->validate('bla'));
        $this->assertFalse($instance->validate('array'));
        $this->assertFalse($instance->validate(123213));
        $this->assertFalse($instance->validate(-12131));
        $this->assertFalse($instance->validate(0x21F124));
        $this->assertFalse($instance->validate(new \stdClass()));
        $this->assertFalse($instance->validate(new \SplFixedArray(4)));
        $this->assertFalse($instance->validate(array()));
        $this->assertFalse($instance->validate([]));
        $this->assertFalse($instance->validate(['key' => 'bla']));
        $this->assertTrue($instance->validate(['key' => 'bla', 'index' => 'blub']));
        $this->assertFalse($instance->validate(null));

        $instance->setKey(1);
        $this->assertFalse($instance->validate(''));
        $this->assertFalse($instance->validate('bla'));
        $this->assertFalse($instance->validate('array'));
        $this->assertFalse($instance->validate(123213));
        $this->assertFalse($instance->validate(-12131));
        $this->assertFalse($instance->validate(0x21F124));
        $this->assertFalse($instance->validate(new \stdClass()));
        $this->assertFalse($instance->validate(new \SplFixedArray(4)));
        $this->assertFalse($instance->validate(array()));
        $this->assertFalse($instance->validate([]));
        $this->assertFalse($instance->validate(['bla']));
        $this->assertTrue($instance->validate(['bla', 'blub']));
        $this->assertFalse($instance->validate(null));
    }

}