<?php

namespace tacone\ApachePhp;

use SimpleXMLElement;

class Line
{

    /**
     * @var SimpleXMLElement
     */
    protected $element;
    /**
     * @var Options 
     */
    protected $options;

    public function __construct(SimpleXMLElement $element = null)
    {
        $this->initialize($element ? : new SimpleXMLElement('<line source="" />'));
    }

    protected function initialize(SimpleXMLElement $element)
    {
        $this->element = $element;
        
        $this->options = new Options();
        $this->options->fromString($this->getRawValue());
        $this->options->onWrite(function(Options $options){
            $this->setRawValue( $options->toString() );
        });
        
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
        $this->getOptions()->fromArray([$value]);
        return $this;
    }
    /**
     * @return Options
     */
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
