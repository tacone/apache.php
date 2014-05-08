<?php

namespace tacone\ApachePhp\Test;

use tacone\ApachePhp\Parser;
use tacone\ApachePhp\Options;


class OptionsTest extends BaseTestCase
{
//	function fakeLine ()
//	{
//		return new \stdClass();
//	}
    function testCount()
    {
        $o = new Options();

        $this->assertEquals(0, count($o));
        $this->assertTrue( !(string)$o );

        $o->fromString('example.net');
		$this->assertEquals(1, count($o));
        $this->assertTrue( !!(string)$o );
        
        $o->fromString('example.net www.example.net');
		$this->assertEquals(2, count($o));
        $this->assertTrue( !!(string)$o );
        
        $o->fromString('example.net www.example.net beta.example.net');
		$this->assertEquals(3, count($o));
        $this->assertTrue( !!(string)$o ); 
        
        $o->fromString(null);
	$this->assertEquals(0, count($o));
        $this->assertTrue( !(string)$o );
        
        $o->fromString('');
	$this->assertEquals(0, count($o));
        $this->assertTrue( !(string)$o );
    }
    public function testGetItem()
    {
        $o = new Options();
        $o[] = 'example.net';
        $this->assertEquals('example.net', $o[0]);
        
        $o = new Options();
        $o->fromString('example.net www.example.net beta.example.net');
        $this->assertEquals('example.net', $o[0]);
        $this->assertEquals('www.example.net', $o[1]);
        $this->assertEquals('beta.example.net', $o[2]);
        
        
    }
}
