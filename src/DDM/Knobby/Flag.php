<?php

namespace DDM\Knobby;

abstract class Flag implements \ArrayAccess, \JsonSerializable
{
    protected $data = [];
    protected $type = null;

    public function __construct($options = array()){
        foreach($options as $key=>$value){
            $this[$key] = $value;
        }
    }

    public function offsetExists($offset){
        return isset($this->data[$offset]);
    }

    public function offsetSet($offset, $value){
        $function_name = "set".ucfirst($offset);
        if(method_exists($this, $function_name)){
            $this->{$function_name}($value);
        }    
    }

    public function offsetUnset($offset){
        unset($this->data[$offset]);
    }

    public function offsetGet($offset){
        return $this->offsetExists($offset) ? $this->data[$offset] : null;
    }

    public function jsonSerialize(){
        return $this->data;
    }

    public function getType(){
        return $this->type;
    }

    abstract public function test($value = null);
}