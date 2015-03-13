<?php
namespace Knobby\Test;

class LeverTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultOn()
    {
        $options = array();
        $lever = new \DDM\Knobby\Lever($options);
        $this->assertTrue($lever->test(), 'Lever should default to on');
    }

    public function testSetOff()
    {
        $options = array(
            'on' => false,
        );
        $lever = new \DDM\Knobby\Lever($options);
        $this->assertFalse($lever->test(), 'Lever should be false');
    }
}
