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

    protected $tokens = array(
        'for'   => Parser::T_FOR,
        'if'    => Parser::T_IF,
        'elif'  => Parser::T_ELIF,
        'else'  => Parser::T_ELSE,
        'set'   => Parser::T_SET,
        'in'    => Parser::T_IN,
        'empty' => Parser::T_EMPTY,
        'end'   => Parser::T_END,
        'and'   => Parser::T_AND,
        '&&'    => Parser::T_AND,
        'or'    => Parser::T_OR,
        'true'  => Parser::T_BOOL,
        'false' => Parser::T_BOOL,
        '||'    => Parser::T_OR,
        'not'   => Parser::T_NOT,
        '!'     => Parser::T_NOT,
        '+'     => Parser::T_PLUS,
        '-'     => Parser::T_MINUS,
        '*'     => Parser::T_TIMES,
        '/'     => Parser::T_DIV,
        '%'     => Parser::T_MOD,
        '=='    => Parser::T_EQ,
        '='     => Parser::T_ASSIGN,
        '<'     => Parser::T_LT,
        '<='     => Parser::T_LE,
        '>'     => Parser::T_GT,
        '>='     => Parser::T_GE,
        '@'     => Parser::T_AT,
        '$'     => Parser::T_DOLLAR,
        '('     => Parser::T_LPARENT,
        ')'     => Parser::T_RPARENT,
        '->'    => Parser::T_OBJ,
        '.'     => Parser::T_DOT,
        '<<'    => Parser::T_BITWISE,
        '>>'    => Parser::T_BITWISE,
        '<|'    => Parser::T_PIPE,
        '|'     => Parser::T_FILTER_PIPE,
        '{'     => Parser::T_CURLY_OPEN,
        '}'     => Parser::T_CURLY_OPEN,
        '['     => Parser::T_BRACKETS_OPEN,
        ']'     => Parser::T_BRACKETS_CLOSE,
        ','     => Parser::T_COMMA,
    );

    protected $tags = array();

    protected $delimiters = array(
        'tagOpen' => '{%',
        'tagClose' => '%}',
        'printOpen' => '{{',
        'printClose' => '}}',
    );

    public function registerTag($name, $block)
    {
        if (isset($this->tags[$name])) {
            throw new \RuntimeException("Traing to register {$name} tag but it already exists");
        }
        if (isset($this->tokens[$name]) && !preg_match('/^[a-z_][a-z0-9_]*/', $name)) {
            throw new \RuntimeException("{$name} is not a valid tag name");
        }
        $this->tags[$name] = $block ? Parser::T_TAG_BLOCK : Parser::T_TAG;
    }

    public function tokenizeFile($file)
    {
        if (!is_readable($file)) {
            throw new \RuntimeExeption("Cannot read file {$file}");
        }
        return $this->tokenize(file_get_contents($file));
    }

    public function tokenize($text)
    {
        krsort($this->tokens);
        $tokens   = array(); 
        $len      = strlen($text);
        $status   = self::IN_TEXT;
        $line     = 1;
        $parser   = new \ReflectionClass('\Haanga2_Compiler_Parser');
        $const    = $parser->getConstants();
        $tagFirst = false;
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
                if ($pos - $i > 0) {
                    $html  = substr($text, $i, $pos - $i);
                    $tokens[] = array(Parser::T_HTML, $html, $line);
                    $line += substr_count($html, "\n");
                }
                if ($pos >= $len) {
                    break;
                }
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
                        $hasDot  = true;
                        break;
                    default:
                        if ($i < $len && ctype_alpha($text[$i])) {
                            throw new \RuntimeException("{$number}{$text[$i]} is not a valid number");
                        }
                        break 2;
                    }
                }
                $tokens[] = array(Parser::T_NUMBER, $number+0, $line);
                $i--; /* decrement because the main loop will incremt us by one */
                break;
            // }}}

            // string {{{
            case '"':
            case "'":
                $end = $text[$i];
                $str = "";
                for ($i++; $i < $len; $i++) {
                    switch ($text[$i]) {
                    case "\\":
                        $str .= $text[++$i];
                        break;
                    case "'": case '"':
                        if ($text[$i] == $end) {
                            break 2;
                        }
                    default:
                        $str .= $text[$i];
                    } 
                }
                $tokens[] = array(Parser::T_STRING, $str, $line);
                break;
            // }}}

            // whitespaces {{{
            case "\n":
                $line++;
            case ' ': case "\t": case "\r":
                continue 2;
            // }}}

            default:
                // search for open/close tags {{{
                foreach ($this->delimiters as $type => $str) {
                    if (substr($text, $i, strlen($str)) == $str) {
                        switch ($type) {
                        case 'tagOpen':
                            if ($status != self::IN_TEXT) {
                                throw new \RuntimeException("Unexpected {$str}");
                            }
                            $status = self::IN_CODE;
                            $tagFirst = true;
                            break;
                        case 'printOpen':
                            if ($status != self::IN_TEXT) {
                                throw new \RuntimeException("Unexpected {$str}");
                            }
                            $tokens[] = array(Parser::T_ECHO, null, $line); 
                            $status   = self::IN_PRINT;
                            break;
                        case 'tagClose':
                        case 'printClose':
                            $status = self::IN_TEXT;
                            break;
                        }
                        $i += strlen($str) - 1;
                        continue 3;
                    }
                }
                // }}}

                // search for the keywords {{{
                $foundToken = false;
                foreach ($this->tokens as $token => $id) {
                    if ($text[$i] > $token[0]) { 
                        //nothing to do here
                        break;
                    }
                    if (strcasecmp(substr($text, $i, strlen($token)), $token) == 0) {
                        $e = $i + strlen($token);
                        if ($e < $len && ctype_alpha($token) && ctype_alpha($text[$e])) {
                            /* it is an alpha, somethin like trueVariable */
                            break; 
                        }
                        $tokens[]   = array($id, $token, $line);
                        $foundToken = true;
                        $i = $e - 1;
                        break;
                    }
                }
                // }}}

                if (!$foundToken) {
                    preg_match('/^[a-z_][a-z0-9_]*/', substr($text, $i), $matches);
                    if (empty($matches)) {
                        throw new \RuntimeException("cannot tokenize: ". substr($text, $i, 1));
                    }
                    if ($tagFirst && isset($this->tags[$matches[0]])) {
                        $tokens[] = array($this->tags[$matches[0]], $matches[0], $line);
                    } else if (strncmp($matches[0], 'end', 3) === 0) {
                        $name = substr($matches[0], 3);
                        $type = Parser::T_ALPHA;
                        if (isset($const['T_END' . strtoupper($name)])) {
                            $type = $const['T_END' . strtoupper($name)];
                        } else if (isset($this->tags[$name]) && $this->tags[$name] == Parser::T_TAG_BLOCK) {
                            $type = Parser::T_END;
                        } 

                        $tokens[] = array($type, $matches[0], $line);
                    } else {
                        $tokens[] = array(Parser::T_ALPHA, $matches[0], $line);
                    }
                    $i += strlen($matches[0])-1;
                }
                break;
            }
            $tagFirst = false;
        }

        return $tokens;
    }
}
