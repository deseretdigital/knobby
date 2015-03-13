<?php

namespace DDM\Knobby;

class Lever extends Flag
{
    protected $data = array(
        'on' => true,
        'dependsOn' => array(),
    );

    public function test($value = null)
    {
        return $this['on'];
    }

    public function setOn($on)
    {
        $this->data['on'] = (bool) $on;
    }
}
