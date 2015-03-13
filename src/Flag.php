<?php

namespace DDM\Knobby;

abstract class Flag implements \ArrayAccess
{
    /**
     * Flag specific data. defaults should be set in each subclass
     * @var array
     */
    protected $data = [];

    /**
     * Name of flag
     * @var string
     */
    protected $name = '';

    /**
     * Type of flag
     * @var string
     */
    protected $type = '';

    public function __construct($options = array())
    {
        foreach ($options as $key => $value) {
            $this[$key] = $value;
        }
    }

    /**
     * Return if the data element exists
     * @param  string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Setting data element
     * @param string $offset name of element
     * @param mixed  $value  value saved
     */
    public function offsetSet($offset, $value)
    {
        $function_name = "set".ucfirst($offset);
        if (method_exists($this, $function_name)) {
            $this->{$function_name}($value);
        }
    }

    /**
     * Remove data element
     * @param string $offset name of element
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * Return data element
     * @param  string $offset name of element
     * @return mixed  value of element
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->data[$offset] : null;
    }

    /**
     * Convert Flag to array
     * @return array
     */
    public function toArray()
    {
        return array('name' => $this->name, 'type' => $this->type) + $this->data;
    }

    /**
     * Serialize Flag as JSON
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDependsOn(array $dependencies)
    {
        $this->data['dependsOn'] = $dependencies;
    }

    public function getDependsOn()
    {
        return $this->data['dependsOn'];
    }

    /**
     * Check to see if feature should be used
     * @param  mixed $value
     * @return bool
     */
    abstract public function test($value = null);
}
