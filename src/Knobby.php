<?php

namespace DDM\Knobby;

class Knobby
{
    protected $flags = array();

    public function __construct(){

    }

    public function loadConfigArray(array $config){
        foreach($config as $item){
            $flag = FlagFactory::createFlag($item);
            $this->addFlag($flag);
        }
    }

    public function addFlag(Flag $flag){
        if($flag->getName()){
            $this->flags[$flag->getName()] = $flag;
        }else{
            trigger_error('Flag must have a name');
        }
    }

    public function loadConfigJson($config){
        $config = json_decode($config, true);
        $this->loadConfigArray($config);
    }

    public function flagExists($name){
        return isset($this->flags[$name]);
    }

    public function toArray(){
        $retVal = array();
        foreach($this->flags as $flag){
            $retVal[]=$flag->toArray();
        }
        return $retVal;
    }

    public function toJson(){
        $retVal = json_encode(array_values($this->flags));
        return $retVal;
    }

    public function test($name, $value = null){
        $retVal = false;
        if(isset($this->flags[$name]) && $this->flags[$name]->test($value)){
            $retVal = true;
            foreach($this->flags[$name]['dependsOn'] as $dependencyName){
                if(!$this->test($dependencyName)){
                    $retVal = false;
                    break;
                }
            }
        }
        return $retVal;
    }
}