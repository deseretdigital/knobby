<?php

use DDM\Knobby\Knob as Knob;

class KnobTest extends PHPUnit_Framework_TestCase
{

    public function testDefaultZero(){
        $options = array();
        $knob = new \DDM\Knobby\Knob($options);
        $expected = 0;
        $this->assertEquals($expected, $knob['value'], 'If a knob does not exist, default should be 0');
    }

    public function testMin(){
        $options = array(
            'min' => 10,
            'max' => 100
        );

        $knob = new Knob($options);
        $knob['threshold'] = 0;
        $expected = 10;
        $this->assertEquals($expected, $knob['threshold'], 'Knob should not go below min value');

    }

    public function testMax(){
        $options = array(
            'min' => 10,
            'max' => 100
        );

        $knob = new Knob($options);
        $knob->setThreshold(200);
        $expected = 100;
        $this->assertEquals($expected, $knob['threshold'], 'Knob should not go above max value');
    }

    public function testMaxGreaterThanMin(){
       $options = array(
            'min' => 10,
            'max' => 100
        );

        $knob = new Knob($options);
        $knob->setMax(5);
        $expected = 10;
        $this->assertEquals($expected, $knob['max'], 'Knob max should always be >= min');

    }

    public function testMinLessThanMax(){
       $options = array(
            'min' => 10,
            'max' => 100
        );

        $knob = new Knob($options);
        $knob->setMin(200);
        $expected = 100;
        $this->assertEquals($expected, $knob['min'], 'Knob min should always be <= max');

    }

    public function testFalseUserValue(){
        $knob = new Knob();
        $knob->setThreshold(30);
        $knob->setUserValue(40);
        $this->assertFalse($knob->test(), 'userValue greater than knob threshold should test false');
    }

    public function testTrueUserValue(){
        $knob = new Knob();
        $knob->setThreshold(30);
        $knob->setUserValue(20);
        $expected = true;
        $this->assertTrue($knob->test(), 'userValue less than knob threshold should test true');
    }

    public function testWithTrueRandomishValue(){
        $knob = \Mockery::mock('\DDM\Knobby\Knob')->makePartial();
        $knob->shouldReceive('createRandomishValue')
             ->andReturn(20);
        $knob->setThreshold(30);
        $this->assertTrue($knob->test(), 'Randomish value less than knob value should test true');
    }

    public function testWithFalseRandomishValue(){
        $knob = \Mockery::mock('\DDM\Knobby\Knob')->makePartial();
        $knob->shouldReceive('createRandomishValue')
             ->andReturn(40);
        $knob->setThreshold(30);
        $expected = false;
        $this->assertFalse($knob->test(), 'Randomish value greater than knob value should test false');
    }

    public function testCreateRandomishValue(){
        $knob = new Knob();
        $value = $knob->createRandomishValue();
        $this->assertTrue($value >= $knob['min'] && $value <= $knob['max']);
    }

}
