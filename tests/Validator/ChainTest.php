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
        $this->assertFalse($chain->reset()->isNull()->isValid());
    }


    public function testOnValidationFailedEvent()
    {
        $chain = new Chain(1);
        $isRunned = false;
        $chain->addValidationFailureListener(function(Rule $rule) use(&$isRunned) {
            $isRunned = true;
        });
        $chain->addValidationFailureListener(function() use(&$isRunned) {
            $isRunned = true;
        });

        $this->assertFalse($isRunned);
        $chain->isArray();
        $this->assertTrue($isRunned);
    }


    public function testThrowExceptionOnFailure()
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

        $chain->throwExceptionOnFailure(false);
        $chain->reset()->isString();

        $chain->throwExceptionOnFailure();
        try {
            $chain->reset()->isString();
            $this->fail('expected exception was not thrown');
        } catch (Exception $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('unexpected exception was thrown');
        }
    }


    public function testStopValidationOnFailure()
    {
        $chain = new Chain(1, ['stopValidationOnFailure' => false]);

        $failures = 0;
        $chain->addValidationFailureListener(function($rule) use (&$failures) {
            $failures++;
        });
        $chain->isString()->isArray()->isInteger();
        $this->assertEquals(2, $failures);

        $chain->stopValidationOnFailure();
        $failures = 0;
        $chain->reset()->isString()->isArray()->isInt();
        $this->assertEquals(1, $failures);
    }


    public function testGetFailures()
    {
        $chain = new Chain(1, ['stopValidationOnFailure' => false]);

        $chain->addValidationFailureListener(function($rule) use (&$failures) {});
        $chain->isString()->isArray()->isInteger();
        $this->assertEquals(2, count($chain->getFailures()));

        $chain->stopValidationOnFailure();
        $chain->reset()->isString()->isArray()->isInteger();
        $this->assertEquals(1, count($chain->getFailures()));

        $chain->stopValidationOnFailure();
        $chain->reset()->isString()->isArray()->isInteger();
        $this->assertInstanceOf('\Validator\Rule\IsString', $chain->getFailures()[0]);
    }


    public function testMaximumLengthOf()
    {
        $chain = new Chain('123');

        $this->assertTrue($chain->maximumLengthOf(3)->isValid());
        $this->assertTrue($chain->maximumLengthOf(4)->isValid());
        $this->assertFalse($chain->maximumLengthOf(2)->isValid());
    }


    public function testMinimumLengthOf()
    {
        $chain = new Chain('123');

        $this->assertTrue($chain->minimumLengthOf(3)->isValid());
        $this->assertTrue($chain->minimumLengthOf(2)->isValid());
        $this->assertFalse($chain->minimumLengthOf(4)->isValid());
    }


    public function testLengthOf()
    {
        $chain = new Chain('123');

        $this->assertTrue($chain->lengthOf(3)->isValid());
        $this->assertFalse($chain->lengthOf(2)->isValid());
        $this->assertFalse($chain->lengthOf(4)->isValid());
    }


    public function testHasKey()
    {
        $chain = new Chain(['index' => 'blblb']);

        $this->assertFalse($chain->hasKey('')->isValid());
        $this->assertFalse($chain->reset()->hasKey('bla')->isValid());
        $this->assertFalse($chain->reset()->hasKey('array')->isValid());
        $this->assertFalse($chain->reset()->hasKey(123213)->isValid());
        $this->assertFalse($chain->reset()->hasKey(-12131)->isValid());
        $this->assertFalse($chain->reset()->hasKey(0x21F124)->isValid());
        $this->assertFalse($chain->reset()->hasKey(new \stdClass())->isValid());
        $this->assertFalse($chain->reset()->hasKey(new \SplFixedArray(4))->isValid());
        $this->assertFalse($chain->reset()->hasKey(array())->isValid());
        $this->assertFalse($chain->reset()->hasKey([])->isValid());
        $this->assertFalse($chain->reset()->hasKey('bla')->isValid());
        $this->assertTrue($chain->reset()->hasKey('index')->isValid());
        $this->assertFalse($chain->reset()->hasKey(null)->isValid());
    }


    public function testHasKeys()
    {
        $chain = new Chain(['index' => 'blblb', 'key' => 'asdasdas']);

        $this->assertTrue($chain->reset()->hasKeys([])->isValid());
        $this->assertTrue($chain->reset()->hasKeys(['key'])->isValid());
        $this->assertTrue($chain->reset()->hasKeys(['index'])->isValid());
        $this->assertTrue($chain->reset()->hasKeys(['key', 'index'])->isValid());
        $this->assertFalse($chain->reset()->hasKeys(['key', 'index', 'bla'])->isValid());
    }


    public function testIsScalar()
    {
        $chain = new Chain('asdasd');
        $this->assertTrue($chain->isScalar()->isValid());

        $chain = new Chain(12312);
        $this->assertTrue($chain->isScalar()->isValid());

        $chain = new Chain([]);
        $this->assertFalse($chain->isScalar()->isValid());

        $chain = new Chain(new \stdClass());
        $this->assertFalse($chain->isScalar()->isValid());
    }

}