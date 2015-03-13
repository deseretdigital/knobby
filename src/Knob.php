<?php

namespace DDM\Knobby;

class Knob extends Flag
{
    protected $data = array(
        'min' => 0,
        'max' => 100,
        'threshold' => 0,
        'userValue' => null,
        'dependsOn' => array(),
    );

    protected $type = 'knob';

    public function test($userValue = null)
    {
        // If manually passed a userValue, save it for later
        if ($userValue) {
            $this['userValue'] = $userValue;
        }
        // get what we have stored
        else {
            $userValue = $this['userValue'];
        }

        // if still null, generate random number
        if (is_null($userValue)) {
            $this['userValue'] = $userValue = $this->createRandomishValue();
        }

        return ($userValue >= $this['min'] && $userValue <= $this['threshold']);
    }

    public function createRandomishValue()
    {
        return rand($this['min'], $this['max']);
    }

    public function setThreshold($threshold)
    {
        if ($threshold < $this['min']) {
            $this->data['threshold'] = $this['min'];
        } elseif ($threshold > $this['max']) {
            $this->data['threshold'] = $this['max'];
        } else {
            $this->data['threshold'] = $threshold;
        }
    }

    public function setMin($min)
    {
        $this->setMaxMin($this->data['max'], $min);
    }

    public function setMax($max)
    {
        $this->setMaxMin($max, $this->data['min']);
    }

    public function setMaxMin($max, $min)
    {
        if ($max > $min) {
            $this->data['max'] = $max;
            $this->data['min'] = $min;
        } else {
            $this->data['max'] = $min;
            $this->data['min'] = $max;
        }
        if (isset($this['threshold'])) {
            $this->setthreshold($this['threshold']);
        }
    }

    public function getUserValue()
    {
        return $this['userValue'];
    }

    public function setUserValue($value)
    {
        $this->data['userValue'] = $value;
    }
}
