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
        $this->assertFalse($chain->reset()->isNumeric()->isValid());
    }


    public function testOnValidationFailedEvent()
    {
        $chain = new Chain(1);
        $isRunned = false;
        $chain->addOnValidationFailedListener(function(Rule $rule) use(&$isRunned) {
            $isRunned = true;
        });

        $this->assertFalse($isRunned);
        $chain->isArray();
        $this->assertTrue($isRunned);
    }


    public function testValidationFailedExceptionListener()
    {
        $chain = new Chain(1, ['throwExceptionOnFailure' => true]);

        try {
            $chain->isString();
            $this->fail('expected exception was not thrown');
        } catch (Exception $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('unexpected exception was thrown');
        }
    }

}