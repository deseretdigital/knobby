<?php

namespace DDM\Knobby\Tests;

use DDM\Knobby\Gate;

class GateTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultUnlocked(){
        $options = array();
        $gate = new Gate($options);
        $this->assertTrue($gate->test(), 'Gate should default to unlocked');
    }

    public function testLockedGateWithoutKey(){
        $gate = new Gate(['locked' => true]);
        $this->assertFalse($gate->test(), 'Gate should be locked and fail with no key provided.');
    }

    public function testLockedGateWithKey(){
        $gate = new Gate(['locked' => true]);
        $this->assertTrue($gate->test(true), 'Locked gate should allow passage if key is provided.');
    }

    public function testUnlockedGateWithoutKey(){
        $gate = new Gate(['locked' => false]);
        $this->assertTrue($gate->test(), 'Unlocked gate should allow passage even in the absence of the key.');
    }

    public function testUnlockedGateWithKey(){
        $gate = new Gate(['locked' => false]);
        $this->assertTrue($gate->test(true), 'Unlocked gate should allow passage with the key.');
    }
}
