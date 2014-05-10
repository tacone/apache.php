<?php

namespace tacone\ApachePhp\Test;

use tacone\ApachePhp\Options;

class OptionsTest extends BaseTestCase
{

    public function testToFromArray()
    {
        $o = new Options();
        $expected = ['example.net', 'www.example.net'];
        $o->fromArray($expected);
        $this->assertEquals($expected, $o->toArray());

        $o = new Options();
        $o->fromArray(null);
        $this->assertEquals([], $o->toArray());
    }

    public function testToFromString()
    {

        $o = new Options();
        $expected = 'example.net www.example.net';
        $o->fromString($expected);
        $this->assertEquals($expected, $o->toString());
        $this->assertEquals($expected, (string) $o );

        $o = new Options();
        $expected = '';
        $o->fromString($expected);
        $this->assertEquals($expected, $o->toString());

        $o = new Options();
        $expected = ' '; //should be trimmed, thus empty
        $o->fromString($expected);
        $this->assertEquals('', $o->toString());

        $o = new Options();
        $expected = 'example.net www.example.net';
        $o->fromString(" ".$expected);
        $this->assertEquals($expected, $o->toString());
        $this->assertEquals($expected, (string) $o );

        // all options should be trimmed
        $o = new Options();
        $expected = 'example.net www.example.net';
        $o->fromString(str_replace(" ", "  ",$expected));
        $this->assertEquals($expected, $o->toString());

    }

    public function testCount()
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
