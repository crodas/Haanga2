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

use Haanga2_Compiler_Parser as Parser;

class Tokenizer
{
    const IN_TEXT  = 0x01;
    const IN_CODE  = 0x02;
    const IN_PRINT = 0x03;

    protected $delimiters = array(
        'tagOpen' => '{%',
        'tagClose' => '%}',
        'printOpen' => '{{',
        'printClose' => '}}',
    );

    public function tokenizeFile($file)
    {
        if (!is_readable($file)) {
            throw new \RuntimeExeption("Cannot read file {$file}");
        }
        return $this->tokenize(file_get_contents($file));
    }

    public function tokenize($text)
    {
        $tokens = array(); 
        $len    = strlen($text);
        $status = self::IN_TEXT;
        $line   = 0;
        for($i=0; $i < $len; $i++) {
            if ($status === self::IN_TEXT) {
                $pos1 = strpos($text, $this->delimiters['tagOpen'], $i);
                $pos2 = strpos($text, $this->delimiters['printOpen'], $i);
                if ($pos1 === false) {
                    $pos1 = $len;
                }
                if ($pos2 === false) {
                    $pos2 = $len;
                }
                $pos  = $pos1 > $pos2 ? $pos2 : $pos1;
                $tokens[] = array(Parser::T_HTML, substr($text, $i, $pos - $i), $line);
                $i = $pos;
            }
            switch ($text[$i]) {
            // number {{{
            case '0': case '1': case '2': case '3': case '4':
            case '5': case '6': case '7': case '8': case '9':
                $number = "";
                $hasDot = false;
                for(; $i < $len; $i++) {
                    switch ($text[$i]) {
                    case '0': case '1': case '2': case '3': case '4':
                    case '5': case '6': case '7': case '8': case '9':
                        $number .= $text[$i];
                        break;
                    case '.':
                        if ($hasDot) {
                            throw new \RuntimeException("Invalid number at line {$line}");
                        }
                        $number .= $text[$i];
                        break;
                    default:
                        if (ctype_alpha($text[$i])) {
                            throw new \RuntimeException("{$number}{$text[$i]} is not a valid number");
                        }
                        break 2;
                    }
                }
                $tokens[] = array(Parser::T_NUMBER, $number+0, $line);
                break;
            // }}}

            default:
                // search for open/close tags
                foreach ($this->delimiters as $type => $str) {
                    if (substr($text, $i, strlen($str)) == $str) {
                        switch ($type) {
                        case 'tagOpen':
                            $status = self::IN_CODE;
                            break;
                        case 'printOpen':
                            $status = self::IN_PRINT;
                            break;
                        case 'tagClose':
                        case 'printClose':
                            $status = self::IN_TEXT;
                            break;
                        }
                        $i += strlen($str) - 1;
                        continue;
                    }
                }
            }
        }
        var_dump($tokens);exit;
    }
}
