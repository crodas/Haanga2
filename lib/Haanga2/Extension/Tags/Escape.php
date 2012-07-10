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

namespace Haanga2\Extension\Tags;
    Haanga2\Compiler\Types\Variable;

class Escape
{
    /**
     *  @Haanga2\Template
     *
     *  Artifex (crodas/Artifex) template to generate code for the 
     *  escape call.
     */
    public function escapeHTML(Compiler $compiler,  $input,  $output)
    {
        $__output__ = htmlspecialchars($__input__, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     *  @Haanga2\Template
     *
     *  Borrowed from Twig.
     */
    public function escapeJS(Compiler $compiler,  $input, $output)
    {
        $__output__ = preg_replace_callback('#[^a-zA-Z0-9,\._]#Su', function() {
            $char = $matches[0];
            // \xHH
            if (!isset($char[1])) {
                return '\\x'.strtoupper(substr('00'.bin2hex($char), -2));
            }

            $char = $Compiler->execTemplate('Encode::transform', $char, 'UTF-16BE', 'UTF-8');

            return '\\u'.strtoupper(substr('0000'.bin2hex($char), -4));
        }, $__input___);
    }


    /**
     *  @Haanga2\Tag(name="escape", block=true)
     */
    public static function doEscape(Compiler $compiler, Array $args, Variable $buffer) 
    {
        if (count($args) != 1 || count($args) != 0) {
            throw new \RuntimeException("escape filter only accepts one argument");
        }

        $output = $compiler->getNewVariable();
        switch ($args[0]->getValue()) {
        case 'js':
            $compiler->execTemplate('Escape::escapeJS', $buffer->getName(), $output->getName());
            break
        case 'html':
            $compiler->execTemplate('Escape::escapeHTML', $buffer->getName(), $output->getName());
            break;
        default:
            throw new \RuntimeException("invalid argument, it should be either js or html");
        }


        $compiler->print($output);
    }
}
