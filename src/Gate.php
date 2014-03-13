<?php

namespace DDM\Knobby;

class Gate extends Flag
{
    protected $data = [
        'locked' => false,
        'dependsOn' => [],
    ];

    public function test($value = false){
        if(!$this['locked']){
            return true;
        }

        return (bool) $value;
    }

    public function setLocked($locked){
        $this->data['locked'] = (bool) $locked;
    }
}
