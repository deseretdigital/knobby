<?php

class KnobbyTest extends PHPUnit_Framework_TestCase
{
    public function testLoadConfigArray(){
        $config = array(
            array(
                'name' => 'testKnob',
                'type' => 'knob',
                'min' => 10,
                'max' => 50,
                'value' => 15,    
            ),
            array(
                'name' => 'testLever',
                'on' => false,
                'type' => 'lever',
            ),
        );
        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigArray($config);
        $expected = true;
        $this->assertEquals($expected, $knobby->flagExists('testKnob'), 'testKnob should exist');
        $this->assertEquals($expected, $knobby->flagExists('testLever'), 'testLever should exist');
    }

    public function testLoadConfigJson(){
       $config = json_encode(array(
            array(
                'name' => 'testKnob',
                'type' => 'knob',
                'min' => 10,
                'max' => 50,
                'value' => 15,    
            ),
            array(
                'name' => 'testLever',
                'on' => false,
                'type' => 'lever',
            ),
        ));

        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigJson($config);
        $expected = true;
        $this->assertEquals($expected, $knobby->flagExists('testKnob'), 'testKnob should exist');
        $this->assertEquals($expected, $knobby->flagExists('testLever'), 'testLever should exist');
    }

    public function testToArray(){
        $config = array(
            array(
                'name' => 'testKnob',
                'type' => 'knob',
                'min' => 10,
                'max' => 50,
                'value' => 15,
                'dependsOn' => [],                
            ),
            array(
                'name' => 'testLever',
                'on' => false,
                'type' => 'lever',
                'dependsOn' => [],    
            ),
        );
        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigArray($config);
        $expected = $config;
        $this->assertEquals($expected, $knobby->toArray(), 'array should match config');
    }

    public function testToJson(){
        $config = json_encode(array(
            array(
                'name' => 'testKnob',
                'type' => 'knob',
                'min' => 10,
                'max' => 50,
                'value' => 15,    
                'dependsOn' => [],    
            ),
            array(
                'name' => 'testLever',
                'on' => false,
                'type' => 'lever',
                'dependsOn' => [],    
            ),
        ));
        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigJson($config);
        $expected = json_decode($config);
        $actual = json_decode($knobby->toJson());
        $this->assertEquals($expected, $actual, 'json should match config');
    }

    public function testUndefinedFlag(){
        $knobby = new \DDM\Knobby\Knobby();
        $expected = false;
        $actual = $knobby->test('undefined');
        $this->assertEquals($expected, $actual, 'Undefined flags should return false');
    }

    public function testTestKnob(){
        $config = array(
            array(
                'name' => 'testKnob',
                'type' => 'knob',
                'min' => 10,
                'max' => 50,
                'value' => 15,    
            ),
        );
        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigArray($config);

        $actual = $knobby->test('testKnob', 13);
        $expected = true;
        $this->assertEquals($expected, $actual, 'knob should work');
    }

    public function testLeverParentOn(){
        $config = array(
            array(
                'name' => 'testParentLever',
                'type' => 'lever',
                'on'   => true,
            ),
            array(
                'name' => 'testChildLever',
                'type' => 'lever',
                'on'   => true,
                'dependsOn' => ['testParentLever'],
            ),
        );

        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigArray($config);

        $actual = $knobby->test('testChildLever');
        $expected = true;
        $this->assertEquals($expected, $actual, 'lever should work since parent and child are both true');
    }

    public function testLeverParentOff(){
        $config = array(
            array(
                'name' => 'testParentLever',
                'type' => 'lever',
                'on'   => false,
            ),
            array(
                'name' => 'testChildLever',
                'type' => 'lever',
                'on'   => true,
                'dependsOn' => ['testParentLever'],
            ),
        );

        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigArray($config);

        $actual = $knobby->test('testChildLever');
        $expected = false;
        $this->assertEquals($expected, $actual, 'lever should not work since parent is false');
    }
    
    public function testLeverGrandParentOff(){
        $config = array(
            array(
                'name' => 'testGrandParentLever',
                'type' => 'lever',
                'on'   => false,
            ),
            array(
                'name' => 'testParentLever',
                'type' => 'lever',
                'on'   => true,
                'dependsOn' => ['testGrandParentLever'],
            ),
            array(
                'name' => 'testChildLever',
                'type' => 'lever',
                'on'   => true,
                'dependsOn' => ['testParentLever'],
            ),
        );

        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigArray($config);

        $actual = $knobby->test('testChildLever');
        $expected = false;
        $this->assertEquals($expected, $actual, 'lever should not work since grandparent is false');
    }

    public function testLeverParentOffGrandParentOn(){
        $config = array(
            array(
                'name' => 'testGrandParentLever',
                'type' => 'lever',
                'on'   => true,
            ),
            array(
                'name' => 'testParentLever',
                'type' => 'lever',
                'on'   => false,
                'dependsOn' => ['testGrandParentLever'],
            ),
            array(
                'name' => 'testChildLever',
                'type' => 'lever',
                'on'   => true,
                'dependsOn' => ['testParentLever'],
            ),
        );

        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigArray($config);

        $actual = $knobby->test('testChildLever');
        $expected = false;
        $this->assertEquals($expected, $actual, 'lever should not work since grandparent is false');
    }    
}