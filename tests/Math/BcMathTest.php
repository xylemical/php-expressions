<?php

namespace Xylemical\Expressions\Math;

use PHPUnit\Framework\TestCase;

class BcMathTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->math = new BcMath(4); // setting a default scale of 4 for these tests
    }

    public function testMultiply()
    {
        $this->assertEquals('0.4000', $this->math->multiply('0.1', '4'));
    }

    public function testMultiplyWithOverriddenScale()
    {
        $this->assertEquals('0.4000000000', $this->math->multiply('0.1', '4', 10));
    }

    public function testSubtract()
    {
        $this->assertEquals('-3.9000', $this->math->subtract('0.1', '4'));
    }

    public function testSubtractWithOverriddenScale()
    {
        $this->assertEquals('-3.9', $this->math->subtract('0.1', '4', 1));
    }

    public function testCompare()
    {
        $this->assertEquals('0', $this->math->compare('4.000', '4'));
        $this->assertEquals('-1', $this->math->compare('0.399', '4'));
        $this->assertEquals('1', $this->math->compare('4.001', '4.000'));
    }

    public function testNative()
    {
        $this->assertEquals(0, $this->math->native('0.00'));
        $this->assertEquals(1, $this->math->native('1'));
        $this->assertEquals(1.0, $this->math->native('1.00'));
    }

    public function testDivide()
    {
        $this->assertEquals('0.0325', $this->math->divide('0.13', '4'));
    }

    public function testDivideWithOverriddenScale()
    {
        $this->assertEquals('0.03', $this->math->divide('0.13', '4', 2));
    }

    public function testAdd()
    {
        $this->assertEquals('4.1000', $this->math->add('0.1', '4'));
    }
    public function testAddWithOverriddenScale()
    {
        $this->assertEquals('4', $this->math->add('0.1', '4', 0));
    }

    public function testModulus()
    {
        $this->assertEquals('1', $this->math->modulus('5', '4'));
    }
}
