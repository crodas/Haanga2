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
    protected $name;
    protected $type;
    protected $parts = array();

    public function __construct($name, $type = 'guess')
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function addPart($part, $default)
    {
        $this->parts[] = func_get_args();
    }

    public function toString(Dumper $vm)
    {
        $variable = '$' . $this->name;
        foreach ($this->parts as $part) {
            $value = $part[0]->toString($vm);
            switch ($part[0]->getType()) {
            case 'guess':
                // we need to guess the variable type
                // TODO:
                //  need to get access to the context if there
                //  is one (in cli we there isn't one) and check
                //  the current value;
                switch ($part[1]) {
                case 'object':
                    $variable .= '->' . substr($value, 1);
                    break;
                case 'array':
                    $variable .= '[' . $value . ']';
                    break;
                }
                break;
            case 'object':
                $variable .= '->' . substr($value, 1);
                break;
            case 'array':
                $variable .= '[' . $value . ']';
                break;
            }
        }
        return $variable;
    }
}


