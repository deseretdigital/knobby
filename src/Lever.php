<?php

namespace DDM\Knobby;

class Lever extends Flag
{
    protected $data = ['on'=>true];

    public function test($value = null){
        return $this['on'];
    }

    public function setOn($on){
        $this->data['on'] = (bool)$on;
    }
}