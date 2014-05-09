<?php

namespace tacone\ApachePhp;

class Options extends \ArrayObject
{

    public function __toString()
    {
        return join(' ', iterator_to_array($this));
    }

    public function fromString($string)
    {
        $string = trim ($string);
        $array = $string ? explode(' ', $string) : array();
        $this->exchangeArray($array);
    }
    public function offsetSet($index, $value)
    {
        parent::offsetSet($index, $value);
        $array = array_filter($this->getArrayCopy());
        $this->exchangeArray(array_values($array));
    }

}
