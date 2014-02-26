<?php

class KnobbyTest extends PHPUnit_Framework_TestCase
{
    public function testLoadConfigArray(){
        $config = array(
            'knobs' => array(
                'testKnob' => array(
                    'min' => 10,
                    'max' => 50    
                )
            ),
            'levers' => array(
                'testLever' => array(
                    'on' => false
                ),
            ),
        );
        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigArray($config);
        $expected = true;
        $this->assertEquals($expected, $knobby->knobExists('testKnob'), 'testKnob should exist');
        $this->assertEquals($expected, $knobby->leverExists('testLever'), 'testLever should exist');
    }

    public function testLoadConfigJson(){
        $config = json_encode(array(
            'knobs' => array(
                'testKnob' => array(
                    'min' => 10,
                    'max' => 50    
                )
            ),
            'levers' => array(
                'testLever' => array(
                    'on' => false
                ),
            ),
        ));

        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigJson($config);
        $expected = true;
        $this->assertEquals($expected, $knobby->knobExists('testKnob'), 'testKnob should exist');
        $this->assertEquals($expected, $knobby->leverExists('testLever'), 'testLever should exist');
    }

    public function testToArray(){
        $config = array(
            'knobs' => array(
                'testKnob' => array(
                    'min' => 10,
                    'max' => 50,
                    'value' => 15,    
                )
            ),
            'levers' => array(
                'testLever' => array(
                    'on' => false
                ),
            ),
        );
        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigArray($config);
        $expected = $config;
        $this->assertEquals($expected, $knobby->toArray(), 'array should match config');
    }

    public function testToJson(){
        $config = json_encode(array(
            'knobs' => array(
                'testKnob' => array(
                    'min' => 10,
                    'max' => 50,
                    'value' => 15,    
                )
            ),
            'levers' => array(
                'testLever' => array(
                    'on' => false
                ),
            ),
        ));
        $knobby = new \DDM\Knobby\Knobby();
        $knobby->loadConfigJson($config);
        $expected = $config;
        $this->assertEquals($expected, $knobby->toJson(), 'array should match config');
    }
}