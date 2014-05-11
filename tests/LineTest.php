<?php

namespace tacone\ApachePhp\Test;

use SimpleXMLElement;
use tacone\ApachePhp\Line;

class LineTest extends BaseTestCase
{
    protected function lineElement($directive = null, $value = null)
    {
        $element =  new SimpleXMLElement('<line source="" />');
        if ($directive) $element['directive'] = $directive;
        if ($value) $element['value'] = $value;
        return $element;
    }

    public function testInit()
    {
        $line = new Line();
        $this->assertFalse($line->isChanged());
        $this->assertEquals(null, $line->getDirective());
        $this->assertEquals(null, $line->getValue());
        $this->assertFalse($line->isChanged());
    }
    public function testElementInit()
    {
        $element = $this->lineElement();
        $element['directive'] = 'DocumentRoot';
        $element['value'] = '/var/www';

        $line = new Line($element);
        $this->assertFalse($line->isChanged());
        $this->assertEquals('DocumentRoot', $line->getDirective());
        $this->assertEquals('/var/www', $line->getValue());
    }

    public function testGetSetValue()
    {
        $line = new Line();
        $this->assertFalse($line->isChanged());
        $this->assertEquals(null, $line->getValue());
        $line->setValue('/var/www');
        $this->assertEquals('/var/www', $line->getValue());
        $this->assertTrue($line->isChanged());
    }
    public function testGetSetDirective()
    {
        $line = new Line();
        $this->assertFalse($line->isChanged());
        $this->assertEquals(null, $line->getDirective());
        $line->setDirective('DocumentRoot');
        $this->assertEquals('DocumentRoot', $line->getDirective());
        $this->assertTrue($line->isChanged());
    }
    
    public function testGetSetOptions()
    {
        $line = new Line();
        $this->assertEquals(0, count($line->getOptions()));
        
        $line = new Line($this->lineElement('DocumentRoot', '/var/www'));
        $this->assertEquals(1, count($line->getOptions()));
        
        $line = new Line();
        $this->assertEquals(0, count($line->getOptions()));
        $line->getOptions()->append('one');
        $this->assertEquals(1, count($line->getOptions()));
        $line->getOptions()->append('two');
        $this->assertEquals(2, count($line->getOptions()));
        
    }
}
