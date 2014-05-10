<?php

namespace tacone\ApachePhp;

use SimpleXMLElement;

class Line
{

    /**
     * @var SimpleXMLElement
     */
    protected $element;

    public function __construct(SimpleXMLElement $element = null)
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
    public function getDirective()
    {
        return $this->element['directive'];
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->element['value'];
    }

    public function setValue($value)
    {
        $this->element['value'] = $value;

        return $this;
    }

    public function isChanged()
    {
        return !isset($this->element['source']);
    }

}
