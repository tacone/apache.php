<?php

namespace tacone\ApachePhp;

use SimpleXMLElement;

class Line
{

    /**
     * @var SimpleXMLElement
     */
    protected $element;
    protected $options;

    public function __construct(SimpleXMLElement $element = null)
    {
        $this->setElement($element ? : new SimpleXMLElement('<line source="" />'));
        $this->options = new Options();
        $this->options->fromString($this->getRawValue());
        $this->options->onWrite(function(Options $options){
            $this->setRawValue( $options->toString() );
        });
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
    
    public function setDirective($value)
    {
        $this->element['directive'] = $value;
        $this->setChanged();

        return $this;
    }
    
    /**
     * @return string
     */
    public function getRawValue()
    {
        return $this->element['value'];
    }

    public function setRawValue($value)
    {
        $this->element['value'] = $value;
        $this->setChanged();

        return $this;
    }
    /**
     * @return string
     */
    public function getValue()
    {
        return $this->getRawValue();
    }

    public function setValue($value)
    {
        $this->setRawValue($value);

        return $this;
    }

    public function getOptions ()
    {
        return $this->options;
    }
    
    public function isChanged()
    {
        return !isset($this->element['source']);
    }

    protected function setChanged()
    {
        unset($this->element['source']);
    }

}
