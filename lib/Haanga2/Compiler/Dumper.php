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

class Dumper
{
    public $buffer = "";
    public $level  = 0;
    public $context = array();

    public function setContext(Array $context)
    {
        $this->context = array_merge($this->context, $context);
    }

    public function contextQuery(Array $query)
    {
        $ctx = $this->context;
        foreach ($query as $part) {
            if (is_array($ctx) && array_key_exists($part, $ctx)) {
                $ctx = $ctx[$part];
            } else if (is_object($ctx) && property_exists($ctx, $part)) {
                $ctx = $ctx->part;
            } else {
                return NULL;
            }
        }
        return $ctx;
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
            foreach ($obj as $i) {
                $i->generate($this);
            }
        } else {
            $obj->generate($this);
        }

        return $this;
    }
}

