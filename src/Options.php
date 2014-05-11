<?php

namespace tacone\ApachePhp;

class Options extends \ArrayObject
{

    protected $writeCallbacks = [];
    
    public function __toString()
    {
        return join(' ', iterator_to_array($this));
    }

    public function fromString($string)
    {
        $string = trim ($string);
        $array = $string ? explode(' ', $string) : array();
        $this->fromArray($array);
    }
    public function toString()
    {
        return (string) $this;
    }
    public function fromArray(array $array = null)
    {
        $array = $array ?: [];
        $array = array_filter($array);
        $this->exchangeArray($array);

        return $this;
    }
    public function toArray()
    {
        return $this->getArrayCopy();
    }
    public function offsetSet($index, $value)
    {
        parent::offsetSet($index, $value);
        $array = array_filter($this->getArrayCopy());
        $this->exchangeArray(array_values($array));
        $this->notifyWrite();
    }
    public function notifyWrite()
    {
        foreach ( $this->writeCallbacks as $callback ) $callback($this);
    }
    public function onWrite(callable $callback)
    {
        $this->writeCallbacks[] = $callback;
        return $this;
    }
}
