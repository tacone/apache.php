<?php

namespace tacone\ApachePhp;

class Options extends \ArrayObject
{

    protected $writeCallbacks = [];

    public function __toString()
    {
        return join(' ', iterator_to_array($this));
    }

    public function fromString($string)
    {
        $string = trim($string);
//        $array = $string ? explode(' ', $string) : array();
        $array = $string ? $this->parseOptions($string) : array();
        $this->fromArray($array);
    }

    /**
     * Ported 1:1 from Rapache
     * 
     * parse a value into a list of multiple options
     * - handles double quote-enclosed strings "example"
     * 
     * TODO: doesn't hanlde single quotes at all :(
     * 
     * @param string $string
     * @return array
     */
    protected function parseOptions($string)
    {
        /*
          if s == None or s == False: return []
          s = s.rstrip()
          s = s.replace ( '\\"', '&quot;' )
          result = '';
          tokens = s.split( '"' )
          for k, v in enumerate( tokens ):
          # replace spaces in every odd token
          if ( k & 1 ) == 1 : tokens[k] = v.replace( ' ', '&nbsp;' )

          s = '"'.join( tokens )
          s = s.replace( '"', '' )
          tokens = s.split( ' ' )
          for k, v in enumerate( tokens ):
          tokens[ k ] = v.replace( '&nbsp;', ' ' )
          tokens[ k ] = tokens[ k ].replace( '&quot;', '"' )
          tokens = [x for x in tokens if x.strip() != '' ]
          return tokens;
         */
        if (!$string) return [];
        $string = rtrim($string);
        $string = str_replace('\"', '&quot;', $string);
        $result = '';

        $tokens = explode('"', $string);
        foreach ($tokens as $key => $value) {
            if ($key & 1 == 1) $tokens[$key] = str_replace(' ', '&nbsp;', $value);
        }

        $string = '"' . join($tokens);
        $string = str_replace('"', '', $string);
        $tokens = explode(' ', $string);
        foreach ($tokens as $key => $value) {
            $tokens[$key] = str_replace('&nbsp;', ' ', $value);
            $tokens[$key] = str_replace('&quot;', '"', $value);
        }
        $tokens = array_filter($tokens);
        return $tokens;
    }

    public function toString()
    {
        return (string) $this;
    }

    public function fromArray(array $array = null)
    {
        $array = $array ? : [];
        $array = array_filter($array);
        $this->exchangeArray($array);
        $this->notifyWrite();

        return $this;
    }

    public function toArray()
    {
        return $this->getArrayCopy();
    }

    public function offsetSet($index, $value)
    {
        parent::offsetSet($index, $value);
        $array = array_filter($this->getArrayCopy());
        $this->exchangeArray(array_values($array));
        $this->notifyWrite();
    }

    public function notifyWrite()
    {
        foreach ($this->writeCallbacks as $callback) $callback($this);
    }

    public function onWrite(callable $callback)
    {
        $this->writeCallbacks[] = $callback;
        return $this;
    }

}
