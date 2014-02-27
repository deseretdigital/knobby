<?php

namespace DDM\Knobby;

class Knob extends Flag
{
    protected $data = [
        'min' => 0,
        'max' => 100,
        'value' => 0,
        'dependsOn' => [],
    ];

    protected $type = 'knob';

    public function test($value = null){
        if(is_null($value)){
            $value = $this->createRandomishValue();
        }
        return ($value >= $this['min'] && $value <= $this['value']);
    }

    public function createRandomishValue(){
        return rand($this['min'], $this['max']);
    }

    public function setValue($value){
        if($value < $this['min']){
            $this->data['value'] = $this['min'];
        }else if($value > $this['max']){
            $this->data['value'] = $this['max'];
        }else{
            $this->data['value'] = $value;
        }
    }

    public function setMin($min){
        $this->setMaxMin($this->data['max'], $min);
    }

    public function setMax($max){
        $this->setMaxMin($max, $this->data['min']);
    }

    public function setMaxMin($max, $min){
        if($max > $min){
            $this->data['max'] = $max;
            $this->data['min'] = $min;
        }else{
            $this->data['max'] = $min;
            $this->data['min'] = $max;
        }
        if(isset($this['value'])){
            $this->setValue($this['value']);
        }
    }

}