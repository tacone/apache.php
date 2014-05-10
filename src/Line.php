<?php

namespace tacone\ApachePhp;

use SimpleXMLElement;

class Line
{

    /**
     * @var SimpleXMLElement 
     */
    protected $element;

    function __construct(SimpleXMLElement $element = null)
    {
        $this->setElement($element ? : new SimpleXMLElement('<line source="" />'));
    }

    protected function setElement(SimpleXMLElement $element)
    {
        $this->element = $element;
        if ($this->isChanged()) throw new \LogicException('Line has no source');
    }

    /**
     * @return string
     */
    function getDirective()
    {
        return $this->element['directive'];
    }

    /**
     * @return string
     */
    function getValue()
    {
        return $this->element['value'];
    }

    function setValue($value)
    {
        $this->element['value'] = $value;
        return $this;
    }

    function isChanged()
    {
        return !isset($this->element['source']);
    }

}
