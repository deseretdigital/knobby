<?php

namespace DDM\Knobby;

class FlagFactory
{
    public static function createFlag(array $flagOptions)
    {
        $type = isset($flagOptions['type']) ? $flagOptions['type'] : 'lever';

        $type = __NAMESPACE__.'\\'.ucfirst(strtolower($type));

        $flag = new $type($flagOptions);

        return $flag;
    }
}
