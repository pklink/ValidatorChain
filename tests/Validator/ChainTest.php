<?php


namespace Validator;


class ChainTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $chain = new Chain('string');

        $this->assertInstanceOf('Validator\Chain', $chain->isString());
        $this->assertTrue($chain->isValid());
        $this->assertTrue($chain->isValid());
        $this->assertFalse($chain->isArray()->isValid());
        $this->assertFalse($chain->isString()->isValid());
        $this->assertTrue($chain->reset()->isValid());
        $this->assertTrue($chain->isString()->isValid());
        $this->assertFalse($chain->reset()->isArray()->isValid());
        $this->assertFalse($chain->reset()->isObject()->isValid());
        $this->assertFalse($chain->reset()->isInteger()->isValid());
        $this->assertFalse($chain->reset()->isInt()->isValid());
    }

}