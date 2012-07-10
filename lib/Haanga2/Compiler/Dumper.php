<?php
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2012 César Rodas and Meneame SL                                   |
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
namespace Haanga2\Compiler;

use \Haanga2\Extension,
    \Haanga2\Compiler\Parser\Term\Variable;

class Dumper
{
    protected $buffer = "";
    protected $level  = 0;
    protected $name   = 'main';
    protected $modules = array();
    protected $localVars = array();
    protected $opt;
    protected $ext;

    public function __construct(Optimizer $opt, Extension $ext = NULL)
    {
        $this->opt = $opt;
        $this->ext = $ext;
    }

    public function getSubModules()
    {
        return $this->modules;
    }

    public function isLocalVariable(Variable $v)
    {
        return isset($this->localVars[$v->getName()]);
    }

    public function setLocalVariable(Variable $v, $isLocal = true)
    {
        $name = $v->getName();
        if ($isLocal) {
            $this->localVars[$name] = true;
        } else if (isset($this->localVars[$name])) {
            unset($this->locaVars[$name]);
        }
        return $this;
    }

    public function registerSubmodule($name, Array $body)
    {
        if (isset($this->modules[$name])) {
            throw new \RuntimeException("Cannot create submodule {$name}, it already exists");
        }
        $this->modules[$name] = $body;
        return $this;
    }

    public function getTag($tag)
    {
        return $this->ext->getTag($tag);
    }

    public function getBuffer()
    {
        return $this->buffer;
    }

    public function method($name)
    {
        return $this->writeLn('public static function ' . $name . '(\Haanga2\Haanga2 $__self, $__context)');
    }

    public function writeLn($line)
    {
        $this->write($line . "\n");
        return $this;
    }

    public function indent()
    {
        $this->level++;
        return $this;
    }

    public function dedent()
    {
        $this->level--;
        return $this;
    }

    public function write($line)
    {
        if (substr($this->buffer, -1) == "\n") {
            $line = str_repeat("    ", $this->level) . $line;
        }

        $this->buffer .= $line;

        return $this;
    }

    public function doPrint($expr)
    {
        if (is_object($expr) && is_callable(array($expr, 'toString'))) {
            $expr = $expr->toString($this);
        }

        if (!is_scalar($expr)) {
            throw new \RuntimeException("Don't know how to print a non-scalar value");
        }
        $this->writeLn("echo {$expr};");
    }

    public function evaluate($obj)
    {
        if (is_array($obj)) {
            foreach ($this->opt->optimize($obj) as $i) {
                $i->generate($this);
            }
        } else {
            $obj->generate($this);
        }

        return $this;
    }
}

