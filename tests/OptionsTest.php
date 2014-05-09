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
        $this->assertTrue(!(string) $o);

        $o->fromString('example.net');
        $this->assertEquals(1, count($o));
        $this->assertTrue(!!(string) $o);

        $o->fromString('example.net www.example.net');
        $this->assertEquals(2, count($o));
        $this->assertTrue(!!(string) $o);

        $o->fromString('example.net www.example.net beta.example.net');
        $this->assertEquals(3, count($o));
        $this->assertTrue(!!(string) $o);

        $o->fromString(null);
        $this->assertEquals(0, count($o));
        $this->assertTrue(!(string) $o);

        $o->fromString('');
        $this->assertEquals(0, count($o));
        $this->assertTrue(!(string) $o);
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

    public function testSetItem()
    {
        /*
          line = FakeLine()
          o = Options( line )
          line.value = 'example.net www.example.net'
          o[0] = 'annodomini.com'
          self.assertEqual( o[0], 'annodomini.com' )
          o[1] = 'www.annodomini.com'
          self.assertEqual( o[1], 'www.annodomini.com' )
          #empty values will cancel the index (and cause everything to scale)
          line.value = 'example.net www.example.net'
          o[0] = ''
          self.assertEqual( o[0], 'www.example.net' )
          line.value = 'example.net www.example.net'
          o[0] = None
          self.assertEqual( o[0], 'www.example.net' )
          try:
          o[1] = 'error.example.net'
          self.assertFalse( 'expecting IndexError exception' )
          except IndexError:
          pass

         */

        $o = new Options();
        $o->fromString('example.net www.example.net');

        $o[0] = 'annodomini.com';
        $this->assertEquals($o[0], 'annodomini.com');

        $o[1] = 'www.annodomini.com';
        $this->assertEquals($o[1], 'www.annodomini.com');

        // empty values will cancel the index (and cause everything to scale)
        $o->fromString('example.net www.example.net');
        $o[0] = '';
        $this->assertEquals($o[0], 'www.example.net');
        
        // empty values will cancel the index (and cause everything to scale)
        $o->fromString('example.net www.example.net');
        $o[0] = null;
        $this->assertEquals($o[0], 'www.example.net');
        $this->assertFalse(isset($o[1]));
    }

}
