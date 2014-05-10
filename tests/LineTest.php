<?php

namespace tacone\ApachePhp\Test;

use SimpleXMLElement;
use tacone\ApachePhp\Line;

class LineTest extends BaseTestCase
{
    protected function lineElement()
    {
        return new SimpleXMLElement('<line source="" />');
    }
    
    public function testInit()
    {
        $line = new Line();
        $this->assertEquals(null, $line->getDirective());
        $this->assertEquals(null, $line->getValue());
    }
    public function testElementInit()
    {
        $element = $this->lineElement();
        $element['directive'] = 'DocumentRoot';
        $element['value'] = '/var/www';
        
        $line = new Line($element);
        $this->assertEquals('DocumentRoot', $line->getDirective());
        $this->assertEquals('/var/www', $line->getValue());
    }
    
    public function testGetSetValue()
    {
        $line = new Line();
        $this->assertEquals(null, $line->getValue());
        $line->setValue('/var/www');
        $this->assertEquals('/var/www', $line->getValue());
        
    }
}
