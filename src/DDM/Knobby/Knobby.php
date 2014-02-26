<?php

namespace DDM\Knobby;

class Knobby
{
    protected $knobs = null;
    protected $levers = null;

    public function __construct(){

    }

    public function loadConfigArray(array $config){
        foreach($config as $type => $items){
            $function_name = 'set'.ucfirst($type);
            if(method_exists($this, $function_name)){
                $this->{$function_name}($items);
            }
        }
    }

    public function loadConfigJson($config){
        $config = json_decode($config, true);
        $this->loadConfigArray($config);
    }

    public function knobExists($name){
        return isset($this->knobs[$name]);
    }

    public function leverExists($name){
        return isset($this->levers[$name]);
    }

    protected function setKnobs(array $knobConfigs){
        $knobs = array();
        foreach($knobConfigs as $name => $knobConfig){
            $knobs[$name] = new Knob($knobConfig);
        }
        $this->knobs = $knobs;
    }
 
    protected function setLevers(array $leverConfigs){
        $levers = array();
        foreach($leverConfigs as $name => $leverConfig){
            $levers[$name] = new Lever($leverConfig);
        }
        $this->levers = $levers;
    }

    public function toArray(){
        $retVal = json_decode($this->toJson(), true);
        return $retVal;
    }

    public function toJson(){
        $retVal = array(
            'knobs' => $this->knobs,
            'levers' => $this->levers,
        );
        $retVal = json_encode($retVal);
        return $retVal;
    }

}