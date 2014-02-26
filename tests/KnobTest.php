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
        $knob['value'] = 0;
        $expected = 10;
        $this->assertEquals($expected, $knob['value'], 'Knob should not go below min value');

    }

    public function testMax(){
        $options = array(
            'min' => 10,
            'max' => 100    
        );

        $knob = new Knob($options);
        $knob->setValue(200);
        $expected = 100;
        $this->assertEquals($expected, $knob['value'], 'Knob should not go above max value');
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

    public function testValue(){
        $knob = new Knob();
        $knob['value'] = 30;
        $value = 40;
        $expected = false;
        $this->assertEquals($expected, $knob->test($value), 'Value greater than knob value should test false');
    }

    public function testWithTrueRandomishValue(){
        $knob = \Mockery::mock('\DDM\Knobby\Knob')->makePartial();
        $knob->shouldReceive('createRandomishValue')
             ->andReturn(20);
        $knob->setValue(30);
        $expected = true;
        $this->assertEquals($expected, $knob->test(), 'Randomish value less than knob value should test true');
    }

    public function testWithFalseRandomishValue(){
        $knob = \Mockery::mock('\DDM\Knobby\Knob')->makePartial();
        $knob->shouldReceive('createRandomishValue')
             ->andReturn(40);
        $knob->setValue(30);
        $expected = false;
        $this->assertEquals($expected, $knob->test(), 'Randomish value greater than knob value should test false');
    }

    public function testCreateRandomishValue(){
        $knob = new Knob();
        $value = $knob->createRandomishValue();
        $this->assertTrue($value >= $knob['min'] && $value <= $knob['max']);        
    }

}