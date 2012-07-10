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
namespace Haanga2;

use Haanga2\Compiler\Tokenizer,
    Haanga2_Compiler_Parser as Parser;

class Haanga2
{
    protected $loader;
    protected $Extension;
    protected $Tokenizer;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
        $this->Tokenizer = new Tokenizer;
        $this->Extension = new Extension($this->Tokenizer);
        $this->Extension->addDirectory(__DIR__ . '/Extension');
    }

    public function compile($source, $id)
    {
        $tokens = $this->Tokenizer->tokenize($source);
        $parser = new Parser;
        foreach ($tokens as $token) {
            $parser->doParse($token[0], $token[1]);
        }
        $parser->doParse(0, 0);
        $opt = new Compiler\Optimizer;
        $vm  = new Compiler\Dumper($opt, $this->Extension);
        $vm->writeLn('class haanga2_' . $id)
            ->writeLn('{')
            ->indent();

        $vm->method('main')
            ->writeLn('{')
            ->indent()
                ->evaluate($parser->body)
            ->dedent()
            ->writeLn('}'); 

        foreach ($vm->getSubModules() as $name => $body) {
            $vm->writeLn('')
                ->method($name)
                ->writeLn('{')
                ->indent()
                    ->evaluate($body)
               ->dedent()
               ->writeLn('}'); 
        }

        $vm->dedent()
           ->writeLn('}'); 
        $code = $vm->getBuffer();

        // evaluate code
        eval('namespace { ' . $code . ' }');

        return $code;
    }

    public function templateIdToClass($name)
    {
        return 'haanga2_' . $name;
    }

    public function load($tpl, $vars = array(), $return = false)
    {
        $tplId = $this->loader->getTplId($tpl);
        $class = $this->templateIdToClass($tplId);
        if (class_exists($class, false)) {
            return $class::main($this, $vars);
        }

        if ($this->loader->load($class, $tpl)) {
            return $class::main($this, $vars);
        }

        /* compile, compile, compile! */
        $code = $this->compile($this->loader->getContent($tpl), $tplId);

        /* save execute */
        $class::main($this, $vars);

        /* save! */
        $this->loader->save($tpl, $code);
    }
}
