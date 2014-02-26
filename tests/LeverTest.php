<?php

class LeverTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultOn(){
        $options = array();
        $lever = new \DDM\Knobby\Lever($options);
        $expected = true;
        $this->assertEquals($expected, $lever->test(), 'Lever should default to on');
    }

    public function testSetOff(){
        $options = array(
            'on' => false
        );
        $lever = new \DDM\Knobby\Lever($options);
        $expected = false;
        $this->assertEquals($expected, $lever->test(), 'Lever should be false');
    }
}