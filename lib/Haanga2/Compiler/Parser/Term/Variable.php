<?php
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2012 César Rodas and Menéame Comunicacions S.L.                   |
  +---------------------------------------------------------------------------------+
  | Redistribution and use in source and binary forms, with or without              |
  | modification, are permitted provided that the following conditions are met:     |
  | 1. Redistributions of source code must retain the above copyright               |
  |    notice, this list of conditions and the following disclaimer.                |
  |                                                                                 |
  | 2. Redistributions in binary form must reproduce the above copyright            |
  |    notice, this list of conditions and the following disclaimer in the          |
  |    documentation and/or other materials provided with the distribution.         |
  |                                                                                 |
  | 3. All advertising materials mentioning features or use of this software        |
  |    must display the following acknowledgement:                                  |
  |    This product includes software developed by César D. Rodas.                  |
  |                                                                                 |
  | 4. Neither the name of the César D. Rodas nor the                               |
  |    names of its contributors may be used to endorse or promote products         |
  |    derived from this software without specific prior written permission.        |
  |                                                                                 |
  | THIS SOFTWARE IS PROVIDED BY CÉSAR D. RODAS ''AS IS'' AND ANY                   |
  | EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED       |
  | WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE          |
  | DISCLAIMED. IN NO EVENT SHALL CÉSAR D. RODAS BE LIABLE FOR ANY                  |
  | DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES      |
  | (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;    |
  | LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND     |
  | ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT      |
  | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS   |
  | SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE                     |
  +---------------------------------------------------------------------------------+
  | Authors: César Rodas <crodas@php.net>                                           |
  +---------------------------------------------------------------------------------+
*/
namespace Haanga2\Compiler\Parser\Term;

use Haanga2\Compiler\Parser\Term,
    Haanga2\Compiler\Dumper;

class Variable extends Term
{
    const T_GUESS  = 0;
    const T_OBJECT = 1;
    const T_ARRAY  = 2;

    protected $name;
    protected $type;
    protected $parts = array();

    public function __construct($name, $type = self::T_GUESS)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isObject()
    {
        return count($this->parts) > 0;
    }

    public function addPart($part, $default)
    {
        $this->parts[] = func_get_args();
    }

    public function toString(Dumper $vm)
    {
        $variable = '$' . $this->name;
        $parts    = array($this->name);
        $type     = $this->getType();
        foreach ($this->parts as $part) {
            $value = $part[0]->toString($vm);
            switch ($type) {
            case self::T_GUESS:
                // we need to guess the variable type,
                // in order to get a better result we
                // check the current value in the context. If
                // we can't find them, we give up, we use their
                // default type
                $ctxValue = $vm->contextQuery($parts);
                if (is_array($ctxValue)) {
                    $part[1] = self::T_ARRAY;
                } else if (is_object($ctxValue)) {
                    $part[1] = self::T_OBJECT;
                }
                switch ($part[1]) {
                case self::T_OBJECT:
                    if ($part[0] instanceof Variable) {
                        $value = substr($value, 1);
                    } else {
                        $value = '{' . $value . '}';
                    }
                    $variable .= '->' . $value;
                    break;
                case self::T_ARRAY:
                    $variable .= '[' . $value . ']';
                    break;
                }
                break;

            case self::T_OBJECT:
                if ($part[0] instanceof Variable) {
                    $value   = substr($value, 1);
                    $parts[] = $value;
                } else {
                    $value = '{' . $value . '}';
                }
                $variable .= '->' . $value;
                break;

            case self::T_ARRAY:
                $variable .= '[' . $value . ']';
                break;
            }

            // Get the current variable type, so we
            //  know how to deal the sub-element /property
            //  of this element if there is any.
            if ($part[0] instanceof Variable) {
                $type = $part[0]->getType();
            } else {
                $type = self::T_GUESS;
            }

        }
        return $variable;
    }
}


