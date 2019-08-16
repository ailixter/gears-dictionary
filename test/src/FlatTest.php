<?php

namespace Ailixter\Gears\Dictionary;

use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-10-31 at 12:41:17.
 */
class FlatTest extends TestCase
{
    /**
     * @var FlatData
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Flat(['x' => 123]);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    public function testExtract()
    {
        self::assertEquals(123, $this->object->extract('x'));
        self::assertFalse($this->object->has('x'));
    }

    public function testExtractDefault()
    {
        self::assertEquals(123, $this->object->extract('undefined', 123));
    }

    public function testRef()
    {
        $x = &$this->object->ref('x');
        self::assertEquals(123, $x);
        $x = 'y';
        self::assertEquals('y', $this->object->get('x'));
    }

    public function testRefUndefined()
    {
        self::assertEquals(null, $this->object->ref('undefined'));
    }

    public function testSet()
    {
        $this->object->set('y', 123);
        self::assertEquals(123, $this->object->get('y'));
    }

    public function testChange()
    {
        $this->object->set('x', 456);
        self::assertEquals(456, $this->object->get('x'));
    }

    public function testSetref()
    {
        $this->object->var = 123;
        $this->object->setref('v', $this->object->var);
        self::assertTrue(true);
        return $this->object;
    }
    /**
     * @depends testSetref
     * @param type $object
     * @return type
     */
    public function testSetref1($object)
    {
        self::assertEquals(123, $object->get('v'));
        $object->set('v', 456);
        return $object;
    }
    /**
     * @depends testSetref
     * @param type $object
     */
    public function testSetref2($object)
    {
        self::assertEquals(456, $object->var);
        return ($object);
    }

    /**
     * @depends testSetref2
     * @param type $object
     * @return type
     */
    public function testUnref($object)
    {
        unset($object['v']);
        $object->set('v', 789);
        self::assertEquals(456, $object->var);
    }

    public function testCount()
    {
        self::assertSame(1, count($this->object));
    }

    public function testOffsetSet()
    {
        $this->object['x'] = 456;
        self::assertSame(456, $this->object['x']);
    }

    public function testOffsetExists()
    {
        self::assertTrue(isset($this->object['x']));
    }

    public function testOffsetNotExists()
    {
        self::assertFalse(isset($this->object['undefined']));
    }

    public function testOffsetUnset()
    {
        unset($this->object['x']);
        self::assertFalse(isset($this->object['x']));
        self::assertEmpty($this->object['x']);
    }

    public function testOffsetGet()
    {
        self::assertSame(123, $this->object['x']);
    }

    public function testOffsetGetUndefined()
    {
        self::assertEmpty($this->object['undefined']);
    }

}
