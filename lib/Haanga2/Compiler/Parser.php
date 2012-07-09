<?php
/* Driver template for the PHP_Haanga2_rGenerator parser generator. (PHP port of LEMON)
*/

/**
 * This can be used to store both the string representation of
 * a token, and any useful meta-data associated with the token.
 *
 * meta-data should be stored as an array
 */
class Haanga2_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof Haanga2_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof Haanga2_yyToken) {
                $this->metadata = $m->metadata;
            } elseif (is_array($m)) {
                $this->metadata = $m;
            }
        }
    }

    function __toString()
    {
        return $this->string;
    }

    function offsetExists($offset)
    {
        return isset($this->metadata[$offset]);
    }

    function offsetGet($offset)
    {
        return $this->metadata[$offset];
    }

    function offsetSet($offset, $value)
    {
        if ($offset === null) {
            if (isset($value[0])) {
                $x = ($value instanceof Haanga2_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof Haanga2_yyToken) {
            if ($value->metadata) {
                $this->metadata[$offset] = $value->metadata;
            }
        } elseif ($value) {
            $this->metadata[$offset] = $value;
        }
    }

    function offsetUnset($offset)
    {
        unset($this->metadata[$offset]);
    }
}

/** The following structure represents a single element of the
 * parser's stack.  Information stored includes:
 *
 *   +  The state number for the parser at this level of the stack.
 *
 *   +  The value of the token stored at this level of the stack.
 *      (In other words, the "major" token.)
 *
 *   +  The semantic value stored at this level of the stack.  This is
 *      the information used by the action routines in the grammar.
 *      It is sometimes called the "minor" token.
 */
class Haanga2_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};

// code external to the class is included here
#line 2 "lib/Haanga2/Compiler/Parser.y"

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

use Haanga2\Compiler\Parser\Term,
    Haanga2\Compiler\Parser\Term\Variable,
    Haanga2\Compiler\Parser\Expr,
    Haanga2\Compiler\Parser\DoPrint,
    Haanga2\Compiler\Parser\DoFor,
    Haanga2\Compiler\Parser\Method,
    Haanga2\Compiler\Parser\DefVariable,
    Haanga2\Compiler\Parser\DoIf;

#line 146 "lib/Haanga2/Compiler/Parser.php"

// declare_class is output here
#line 49 "lib/Haanga2/Compiler/Parser.y"
 class Haanga2_Compiler_Parser #line 151 "lib/Haanga2/Compiler/Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 50 "lib/Haanga2/Compiler/Parser.y"

    protected $lex;
    protected $file;

    function Error($text)
    {
        throw new \RuntimeException($text);
    }

#line 166 "lib/Haanga2/Compiler/Parser.php"

/* Next is all token values, as class constants
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
    const T_NOT                          =  1;
    const T_AND                          =  2;
    const T_OR                           =  3;
    const T_QUESTION                     =  4;
    const T_COLON                        =  5;
    const T_COMMA                        =  6;
    const T_DOT                          =  7;
    const T_OBJ                          =  8;
    const T_BRACKET_OPEN                 =  9;
    const T_NE                           = 10;
    const T_EQ                           = 11;
    const T_GT                           = 12;
    const T_GE                           = 13;
    const T_LT                           = 14;
    const T_LE                           = 15;
    const T_IN                           = 16;
    const T_PLUS                         = 17;
    const T_MINUS                        = 18;
    const T_CONCAT                       = 19;
    const T_TIMES                        = 20;
    const T_DIV                          = 21;
    const T_MOD                          = 22;
    const T_PIPE                         = 23;
    const T_BITWISE                      = 24;
    const T_FILTER_PIPE                  = 25;
    const T_HTML                         = 26;
    const T_ECHO                         = 27;
    const T_FOR                          = 28;
    const T_LPARENT                      = 29;
    const T_RPARENT                      = 30;
    const T_EMPTY                        = 31;
    const T_END                          = 32;
    const T_ENDFOR                       = 33;
    const T_IF                           = 34;
    const T_ELIF                         = 35;
    const T_ELSE                         = 36;
    const T_ENDIF                        = 37;
    const T_TAG                          = 38;
    const T_TAG_BLOCK                    = 39;
    const T_SET                          = 40;
    const T_ASSIGN                       = 41;
    const T_DOLLAR                       = 42;
    const T_AT                           = 43;
    const T_BRACKET_CLOSE                = 44;
    const T_CURLY_OPEN                   = 45;
    const T_CURLY_CLOSE                  = 46;
    const T_BOOL                         = 47;
    const T_NUMBER                       = 48;
    const T_STRING                       = 49;
    const T_ALPHA                        = 50;
    const YY_NO_ACTION = 194;
    const YY_ACCEPT_ACTION = 193;
    const YY_ERROR_ACTION = 192;

/* Next are that tables used to determine what action to take based on the
** current state and lookahead token.  These tables are used to implement
** functions that take a state number and lookahead value and return an
** action integer.  
**
** Suppose the action integer is N.  Then the action is determined as
** follows
**
**   0 <= N < self::YYNSTATE                              Shift N.  That is,
**                                                        push the lookahead
**                                                        token onto the stack
**                                                        and goto state N.
**
**   self::YYNSTATE <= N < self::YYNSTATE+self::YYNRULE   Reduce by rule N-YYNSTATE.
**
**   N == self::YYNSTATE+self::YYNRULE                    A syntax error has occurred.
**
**   N == self::YYNSTATE+self::YYNRULE+1                  The parser accepts its
**                                                        input. (and concludes parsing)
**
**   N == self::YYNSTATE+self::YYNRULE+2                  No such action.  Denotes unused
**                                                        slots in the yy_action[] table.
**
** The action table is constructed as a single large static array $yy_action.
** Given state S and lookahead X, the action is computed as
**
**      self::$yy_action[self::$yy_shift_ofst[S] + X ]
**
** If the index value self::$yy_shift_ofst[S]+X is out of range or if the value
** self::$yy_lookahead[self::$yy_shift_ofst[S]+X] is not equal to X or if
** self::$yy_shift_ofst[S] is equal to self::YY_SHIFT_USE_DFLT, it means that
** the action is not in the table and that self::$yy_default[S] should be used instead.  
**
** The formula above is for computing the action when the lookahead is
** a terminal symbol.  If the lookahead is a non-terminal (as occurs after
** a reduce action) then the static $yy_reduce_ofst array is used in place of
** the static $yy_shift_ofst array and self::YY_REDUCE_USE_DFLT is used in place of
** self::YY_SHIFT_USE_DFLT.
**
** The following are the tables generated in this section:
**
**  self::$yy_action        A single table containing all actions.
**  self::$yy_lookahead     A table containing the lookahead for each entry in
**                          yy_action.  Used to detect hash collisions.
**  self::$yy_shift_ofst    For each state, the offset into self::$yy_action for
**                          shifting terminals.
**  self::$yy_reduce_ofst   For each state, the offset into self::$yy_action for
**                          shifting non-terminals after a reduce.
**  self::$yy_default       Default action for each state.
*/
    const YY_SZ_ACTTAB = 652;
static public $yy_action = array(
 /*     0 */    22,   23,   12,   12,   12,    7,    6,   20,   10,   10,
 /*    10 */    10,   10,   10,   10,    9,    8,    8,    8,   12,   12,
 /*    20 */    12,    7,    6,   22,   23,  193,   46,   43,   93,   30,
 /*    30 */    27,   10,   10,   10,   10,   10,   10,    9,    8,    8,
 /*    40 */     8,   12,   12,   12,    7,    6,   22,   23,   38,   38,
 /*    50 */    24,   91,   18,    4,   10,   10,   10,   10,   10,   10,
 /*    60 */     9,    8,    8,    8,   12,   12,   12,    7,    6,   10,
 /*    70 */    10,   10,   10,   10,   10,    9,    8,    8,    8,   12,
 /*    80 */    12,   12,    7,    6,    7,    6,   14,   40,   87,   49,
 /*    90 */   105,   22,   23,  107,   81,   33,  120,  111,  104,   10,
 /*   100 */    10,   10,   10,   10,   10,    9,    8,    8,    8,   12,
 /*   110 */    12,   12,    7,    6,   10,   10,   10,   10,   10,    9,
 /*   120 */     8,    8,    8,   12,   12,   12,    7,    6,  101,   21,
 /*   130 */    32,   99,  116,   96,  102,  113,   15,  106,   22,   23,
 /*   140 */    25,   26,   37,    1,  100,   96,   10,   10,   10,   10,
 /*   150 */    10,   10,    9,    8,    8,    8,   12,   12,   12,    7,
 /*   160 */     6,   23,   39,   38,   38,   24,   35,  109,   10,   10,
 /*   170 */    10,   10,   10,   10,    9,    8,    8,    8,   12,   12,
 /*   180 */    12,    7,    6,  101,   21,   32,   50,   88,   34,   97,
 /*   190 */   107,   15,   19,   57,   97,   25,   26,   37,   17,   14,
 /*   200 */     1,   14,  101,   21,   32,   96,    2,   58,   94,   94,
 /*   210 */    15,   51,  117,   83,   25,   26,   37,    2,  118,  101,
 /*   220 */    21,   32,   36,  142,   92,  119,   11,   15,   53,   52,
 /*   230 */   119,   25,   26,   37,   51,   29,   99,    5,    1,   53,
 /*   240 */    52,  103,   28,    2,  121,  123,  122,   99,   45,   44,
 /*   250 */    53,   52,  142,   28,  142,  121,  123,  122,   99,  101,
 /*   260 */    21,   32,  112,   13,  142,  115,  115,   15,    2,  142,
 /*   270 */    84,   25,   26,   37,   47,  114,   53,   52,  107,   28,
 /*   280 */   142,  121,  123,  122,   99,    8,    8,    8,   12,   12,
 /*   290 */    12,    7,    6,  142,  142,  142,   96,   38,   38,   24,
 /*   300 */   142,   53,   52,  124,   28,  142,  121,  123,  122,   99,
 /*   310 */   101,   21,   32,  142,  142,  142,   69,  142,   15,    3,
 /*   320 */    98,   49,   25,   26,   37,  107,   82,  142,  120,   65,
 /*   330 */   142,   77,   54,   98,   49,   14,  107,  142,  107,   82,
 /*   340 */    65,  120,  110,   48,   98,   49,  142,  107,  142,  107,
 /*   350 */    82,   49,  120,   80,  142,  107,   81,   65,  120,  142,
 /*   360 */    75,   98,   49,  142,  142,  142,  107,   82,   65,  120,
 /*   370 */    76,  142,   98,   49,  142,  142,  142,  107,   82,   42,
 /*   380 */   120,   79,  142,   98,   49,  142,  142,  142,  107,   82,
 /*   390 */    49,  120,   55,  142,  107,   85,   64,  120,  142,  142,
 /*   400 */    98,   49,  142,   31,  142,  107,   82,  142,  120,   68,
 /*   410 */   142,  142,  142,   98,   49,  142,  142,  142,  107,   82,
 /*   420 */   142,  120,   66,  142,  142,  142,   98,   49,  142,  142,
 /*   430 */   142,  107,   82,   61,  120,  142,  142,   98,   49,   38,
 /*   440 */    38,   24,  107,   82,   74,  120,  142,  142,   98,   49,
 /*   450 */   142,  142,  142,  107,   82,  142,  120,   86,  142,  142,
 /*   460 */   142,   98,   49,  142,  142,  142,  107,   82,  142,  120,
 /*   470 */    90,  142,  142,   16,   98,   49,  142,   14,  142,  107,
 /*   480 */    82,  142,  120,   73,  142,  142,  142,   98,   49,  142,
 /*   490 */   142,  142,  107,   82,   72,  120,  142,  142,   98,   49,
 /*   500 */   142,  142,  142,  107,   82,   78,  120,  142,  142,   98,
 /*   510 */    49,  142,  142,  142,  107,   82,  142,  120,   60,  142,
 /*   520 */   142,  142,   98,   49,  142,  142,  142,  107,   82,  142,
 /*   530 */   120,   59,  142,  142,  142,   98,   49,  142,  142,  142,
 /*   540 */   107,   82,  142,  120,   41,  142,  142,  142,   98,   49,
 /*   550 */   142,  142,  142,  107,   82,   63,  120,  142,  142,   98,
 /*   560 */    49,  142,  142,  142,  107,   82,   70,  120,  142,  142,
 /*   570 */    98,   49,  142,  142,  142,  107,   82,  142,  120,   71,
 /*   580 */   142,  142,  142,   98,   49,  142,  142,  142,  107,   82,
 /*   590 */   142,  120,   67,  142,  142,  142,   98,   49,  142,  142,
 /*   600 */   142,  107,   82,  142,  120,   62,  142,  142,  142,   98,
 /*   610 */    49,  142,  142,  142,  107,   82,   49,  120,  125,  142,
 /*   620 */   107,   85,  142,  120,   56,  142,   95,   49,  142,   31,
 /*   630 */   142,  107,   82,  142,  120,  142,   49,  142,  142,  142,
 /*   640 */   107,   89,  142,  120,   49,  142,  142,  142,  107,  108,
 /*   650 */   142,  120,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,    3,   20,   21,   22,   23,   24,    5,   10,   11,
 /*    10 */    12,   13,   14,   15,   16,   17,   18,   19,   20,   21,
 /*    20 */    22,   23,   24,    2,    3,   52,   53,   53,   30,    5,
 /*    30 */    16,   10,   11,   12,   13,   14,   15,   16,   17,   18,
 /*    40 */    19,   20,   21,   22,   23,   24,    2,    3,    7,    8,
 /*    50 */     9,   30,    6,   29,   10,   11,   12,   13,   14,   15,
 /*    60 */    16,   17,   18,   19,   20,   21,   22,   23,   24,   10,
 /*    70 */    11,   12,   13,   14,   15,   16,   17,   18,   19,   20,
 /*    80 */    21,   22,   23,   24,   23,   24,   45,   25,   44,   60,
 /*    90 */    44,    2,    3,   64,   65,   25,   67,   63,   69,   10,
 /*   100 */    11,   12,   13,   14,   15,   16,   17,   18,   19,   20,
 /*   110 */    21,   22,   23,   24,   11,   12,   13,   14,   15,   16,
 /*   120 */    17,   18,   19,   20,   21,   22,   23,   24,   26,   27,
 /*   130 */    28,   50,   72,   54,   32,   46,   34,   58,    2,    3,
 /*   140 */    38,   39,   40,    6,   64,   54,   10,   11,   12,   13,
 /*   150 */    14,   15,   16,   17,   18,   19,   20,   21,   22,   23,
 /*   160 */    24,    3,    6,    7,    8,    9,   53,   30,   10,   11,
 /*   170 */    12,   13,   14,   15,   16,   17,   18,   19,   20,   21,
 /*   180 */    22,   23,   24,   26,   27,   28,   60,   64,   53,   32,
 /*   190 */    64,   34,   35,   36,   37,   38,   39,   40,    1,   45,
 /*   200 */     6,   45,   26,   27,   28,   54,    9,   31,   32,   33,
 /*   210 */    34,   64,   61,   66,   38,   39,   40,    9,   71,   26,
 /*   220 */    27,   28,   53,   74,   30,   32,   29,   34,   42,   43,
 /*   230 */    37,   38,   39,   40,   64,    6,   50,   29,    6,   42,
 /*   240 */    43,   71,   45,    9,   47,   48,   49,   50,   53,   53,
 /*   250 */    42,   43,   74,   45,   74,   47,   48,   49,   50,   26,
 /*   260 */    27,   28,   30,   29,   74,   32,   33,   34,    9,   74,
 /*   270 */    56,   38,   39,   40,   60,   46,   42,   43,   64,   45,
 /*   280 */    74,   47,   48,   49,   50,   17,   18,   19,   20,   21,
 /*   290 */    22,   23,   24,   74,   74,   74,   54,    7,    8,    9,
 /*   300 */    74,   42,   43,   61,   45,   74,   47,   48,   49,   50,
 /*   310 */    26,   27,   28,   74,   74,   74,   55,   74,   34,   29,
 /*   320 */    59,   60,   38,   39,   40,   64,   65,   74,   67,   55,
 /*   330 */    74,   70,   60,   59,   60,   45,   64,   74,   64,   65,
 /*   340 */    55,   67,   68,   60,   59,   60,   74,   64,   74,   64,
 /*   350 */    65,   60,   67,   68,   74,   64,   65,   55,   67,   74,
 /*   360 */    69,   59,   60,   74,   74,   74,   64,   65,   55,   67,
 /*   370 */    68,   74,   59,   60,   74,   74,   74,   64,   65,   55,
 /*   380 */    67,   68,   74,   59,   60,   74,   74,   74,   64,   65,
 /*   390 */    60,   67,   62,   74,   64,   65,   55,   67,   74,   74,
 /*   400 */    59,   60,   74,   73,   74,   64,   65,   74,   67,   55,
 /*   410 */    74,   74,   74,   59,   60,   74,   74,   74,   64,   65,
 /*   420 */    74,   67,   55,   74,   74,   74,   59,   60,   74,   74,
 /*   430 */    74,   64,   65,   55,   67,   74,   74,   59,   60,    7,
 /*   440 */     8,    9,   64,   65,   55,   67,   74,   74,   59,   60,
 /*   450 */    74,   74,   74,   64,   65,   74,   67,   55,   74,   74,
 /*   460 */    74,   59,   60,   74,   74,   74,   64,   65,   74,   67,
 /*   470 */    55,   74,   74,   41,   59,   60,   74,   45,   74,   64,
 /*   480 */    65,   74,   67,   55,   74,   74,   74,   59,   60,   74,
 /*   490 */    74,   74,   64,   65,   55,   67,   74,   74,   59,   60,
 /*   500 */    74,   74,   74,   64,   65,   55,   67,   74,   74,   59,
 /*   510 */    60,   74,   74,   74,   64,   65,   74,   67,   55,   74,
 /*   520 */    74,   74,   59,   60,   74,   74,   74,   64,   65,   74,
 /*   530 */    67,   55,   74,   74,   74,   59,   60,   74,   74,   74,
 /*   540 */    64,   65,   74,   67,   55,   74,   74,   74,   59,   60,
 /*   550 */    74,   74,   74,   64,   65,   55,   67,   74,   74,   59,
 /*   560 */    60,   74,   74,   74,   64,   65,   55,   67,   74,   74,
 /*   570 */    59,   60,   74,   74,   74,   64,   65,   74,   67,   55,
 /*   580 */    74,   74,   74,   59,   60,   74,   74,   74,   64,   65,
 /*   590 */    74,   67,   55,   74,   74,   74,   59,   60,   74,   74,
 /*   600 */    74,   64,   65,   74,   67,   55,   74,   74,   74,   59,
 /*   610 */    60,   74,   74,   74,   64,   65,   60,   67,   62,   74,
 /*   620 */    64,   65,   74,   67,   57,   74,   59,   60,   74,   73,
 /*   630 */    74,   64,   65,   74,   67,   74,   60,   74,   74,   74,
 /*   640 */    64,   65,   74,   67,   60,   74,   74,   74,   64,   65,
 /*   650 */    74,   67,
);
    const YY_SHIFT_USE_DFLT = -19;
    const YY_SHIFT_MAX = 84;
    static public $yy_shift_ofst = array(
 /*     0 */   -19,  197,  197,  197,  197,  197,  197,  197,  197,  197,
 /*    10 */   197,  197,  197,  197,  197,  197,  197,  197,  197,  197,
 /*    20 */   197,  197,  197,  197,  197,  208,  208,  234,  259,  259,
 /*    30 */   259,  259,  186,   81,  157,  157,  176,  186,  186,  186,
 /*    40 */    81,  136,  136,  233,  193,  102,  284,  156,  432,  290,
 /*    50 */    41,   24,   81,   81,  154,  -19,  -19,  -19,  -19,   89,
 /*    60 */    21,   -2,   44,  136,  136,  136,  136,  136,  136,  136,
 /*    70 */   158,   59,  103,  268,  -18,  229,  194,   46,   61,  232,
 /*    80 */   137,    2,   70,   62,   14,
);
    const YY_REDUCE_USE_DFLT = -28;
    const YY_REDUCE_MAX = 58;
    static public $yy_reduce_ofst = array(
 /*     0 */   -27,  274,  261,  285,  313,  302,  415,  402,  389,  428,
 /*    10 */   439,  463,  450,  378,  476,  324,  367,  354,  341,  489,
 /*    20 */   537,  500,  511,  524,  550,  556,  330,  567,  291,   29,
 /*    30 */   584,  576,  214,  147,  242,  151,   79,  283,  272,  126,
 /*    40 */   170,  113,  135,   91,   91,   91,   91,   34,   34,   34,
 /*    50 */    34,   60,   80,  123,   34,  195,  169,  196,  -26,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 2 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 3 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 4 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 5 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 6 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 7 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 8 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 9 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 10 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 11 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 12 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 13 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 14 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 15 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 16 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 17 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 18 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 19 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 20 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 21 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 22 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 23 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 24 */ array(1, 9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 25 */ array(9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 26 */ array(9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 27 */ array(9, 29, 42, 43, 45, 47, 48, 49, 50, ),
        /* 28 */ array(9, 42, 43, 45, 47, 48, 49, 50, ),
        /* 29 */ array(9, 42, 43, 45, 47, 48, 49, 50, ),
        /* 30 */ array(9, 42, 43, 45, 47, 48, 49, 50, ),
        /* 31 */ array(9, 42, 43, 45, 47, 48, 49, 50, ),
        /* 32 */ array(42, 43, 50, ),
        /* 33 */ array(50, ),
        /* 34 */ array(26, 27, 28, 32, 34, 35, 36, 37, 38, 39, 40, ),
        /* 35 */ array(26, 27, 28, 32, 34, 35, 36, 37, 38, 39, 40, ),
        /* 36 */ array(26, 27, 28, 31, 32, 33, 34, 38, 39, 40, ),
        /* 37 */ array(42, 43, 50, ),
        /* 38 */ array(42, 43, 50, ),
        /* 39 */ array(42, 43, 50, ),
        /* 40 */ array(50, ),
        /* 41 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 42 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 43 */ array(26, 27, 28, 32, 33, 34, 38, 39, 40, ),
        /* 44 */ array(26, 27, 28, 32, 34, 37, 38, 39, 40, ),
        /* 45 */ array(26, 27, 28, 32, 34, 38, 39, 40, ),
        /* 46 */ array(26, 27, 28, 34, 38, 39, 40, ),
        /* 47 */ array(6, 7, 8, 9, 45, ),
        /* 48 */ array(7, 8, 9, 41, 45, ),
        /* 49 */ array(7, 8, 9, 29, 45, ),
        /* 50 */ array(7, 8, 9, 45, ),
        /* 51 */ array(5, 29, ),
        /* 52 */ array(50, ),
        /* 53 */ array(50, ),
        /* 54 */ array(45, ),
        /* 55 */ array(),
        /* 56 */ array(),
        /* 57 */ array(),
        /* 58 */ array(),
        /* 59 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 46, ),
        /* 60 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 30, ),
        /* 61 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 30, ),
        /* 62 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 44, ),
        /* 63 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 64 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 65 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 66 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 67 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 68 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 69 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 70 */ array(3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 71 */ array(10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 72 */ array(11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 73 */ array(17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 74 */ array(20, 21, 22, 23, 24, ),
        /* 75 */ array(6, 46, ),
        /* 76 */ array(6, 30, ),
        /* 77 */ array(6, 44, ),
        /* 78 */ array(23, 24, ),
        /* 79 */ array(6, 30, ),
        /* 80 */ array(6, 30, ),
        /* 81 */ array(5, ),
        /* 82 */ array(25, ),
        /* 83 */ array(25, ),
        /* 84 */ array(16, ),
        /* 85 */ array(),
        /* 86 */ array(),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(),
        /* 90 */ array(),
        /* 91 */ array(),
        /* 92 */ array(),
        /* 93 */ array(),
        /* 94 */ array(),
        /* 95 */ array(),
        /* 96 */ array(),
        /* 97 */ array(),
        /* 98 */ array(),
        /* 99 */ array(),
        /* 100 */ array(),
        /* 101 */ array(),
        /* 102 */ array(),
        /* 103 */ array(),
        /* 104 */ array(),
        /* 105 */ array(),
        /* 106 */ array(),
        /* 107 */ array(),
        /* 108 */ array(),
        /* 109 */ array(),
        /* 110 */ array(),
        /* 111 */ array(),
        /* 112 */ array(),
        /* 113 */ array(),
        /* 114 */ array(),
        /* 115 */ array(),
        /* 116 */ array(),
        /* 117 */ array(),
        /* 118 */ array(),
        /* 119 */ array(),
        /* 120 */ array(),
        /* 121 */ array(),
        /* 122 */ array(),
        /* 123 */ array(),
        /* 124 */ array(),
        /* 125 */ array(),
);
    static public $yy_default = array(
 /*     0 */   128,  191,  192,  191,  191,  191,  192,  192,  192,  192,
 /*    10 */   192,  192,  192,  192,  192,  192,  192,  192,  192,  192,
 /*    20 */   192,  192,  192,  192,  192,  181,  181,  192,  192,  192,
 /*    30 */   192,  183,  192,  192,  192,  192,  192,  192,  192,  192,
 /*    40 */   192,  128,  128,  192,  192,  192,  126,  134,  192,  167,
 /*    50 */   135,  186,  192,  192,  146,  128,  128,  128,  128,  192,
 /*    60 */   192,  192,  192,  130,  176,  190,  144,  175,  152,  177,
 /*    70 */   153,  154,  155,  156,  158,  192,  192,  192,  157,  192,
 /*    80 */   192,  192,  164,  163,  192,  185,  160,  150,  148,  184,
 /*    90 */   159,  161,  182,  133,  137,  132,  127,  141,  162,  171,
 /*   100 */   149,  129,  143,  178,  174,  173,  131,  147,  187,  170,
 /*   110 */   189,  145,  188,  151,  172,  136,  180,  139,  179,  140,
 /*   120 */   165,  166,  169,  168,  138,  142,
);
/* The next thing included is series of defines which control
** various aspects of the generated parser.
**    self::YYNOCODE      is a number which corresponds
**                        to no legal terminal or nonterminal number.  This
**                        number is used to fill in empty slots of the hash 
**                        table.
**    self::YYFALLBACK    If defined, this indicates that one or more tokens
**                        have fall-back values which should be used if the
**                        original value of the token will not parse.
**    self::YYSTACKDEPTH  is the maximum depth of the parser's stack.
**    self::YYNSTATE      the combined number of states.
**    self::YYNRULE       the number of rules in the grammar
**    self::YYERRORSYMBOL is the code number of the error symbol.  If not
**                        defined, then do no error processing.
*/
    const YYNOCODE = 75;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 126;
    const YYNRULE = 66;
    const YYERRORSYMBOL = 51;
    const YYERRSYMDT = 'yy0';
    const YYFALLBACK = 0;
    /** The next table maps tokens into fallback tokens.  If a construct
     * like the following:
     * 
     *      %fallback ID X Y Z.
     *
     * appears in the grammer, then ID becomes a fallback token for X, Y,
     * and Z.  Whenever one of the tokens X, Y, or Z is input to the parser
     * but it does not parse, the type of the token is changed to ID and
     * the parse is retried before an error is thrown.
     */
    static public $yyFallback = array(
    );
    /**
     * Turn parser tracing on by giving a stream to which to write the trace
     * and a prompt to preface each trace message.  Tracing is turned off
     * by making either argument NULL 
     *
     * Inputs:
     * 
     * - A stream resource to which trace output should be written.
     *   If NULL, then tracing is turned off.
     * - A prefix string written at the beginning of every
     *   line of trace output.  If NULL, then tracing is
     *   turned off.
     *
     * Outputs:
     * 
     * - None.
     * @param resource
     * @param string
     */
    static function Trace($TraceFILE, $zTracePrompt)
    {
        if (!$TraceFILE) {
            $zTracePrompt = 0;
        } elseif (!$zTracePrompt) {
            $TraceFILE = 0;
        }
        self::$yyTraceFILE = $TraceFILE;
        self::$yyTracePrompt = $zTracePrompt;
    }

    /**
     * Output debug information to output (php://output stream)
     */
    static function PrintTrace()
    {
        self::$yyTraceFILE = fopen('php://output', 'w');
        self::$yyTracePrompt = '';
    }

    /**
     * @var resource|0
     */
    static public $yyTraceFILE;
    /**
     * String to prepend to debug output
     * @var string|0
     */
    static public $yyTracePrompt;
    /**
     * @var int
     */
    public $yyidx = -1;                    /* Index of top element in stack */
    /**
     * @var int
     */
    public $yyerrcnt;                 /* Shifts left before out of the error */
    /**
     * @var array
     */
    public $yystack = array();  /* The parser's stack */

    /**
     * For tracing shifts, the names of all terminals and nonterminals
     * are required.  The following table supplies these names
     * @var array
     */
    static public $yyTokenName = array( 
  '$',             'T_NOT',         'T_AND',         'T_OR',        
  'T_QUESTION',    'T_COLON',       'T_COMMA',       'T_DOT',       
  'T_OBJ',         'T_BRACKET_OPEN',  'T_NE',          'T_EQ',        
  'T_GT',          'T_GE',          'T_LT',          'T_LE',        
  'T_IN',          'T_PLUS',        'T_MINUS',       'T_CONCAT',    
  'T_TIMES',       'T_DIV',         'T_MOD',         'T_PIPE',      
  'T_BITWISE',     'T_FILTER_PIPE',  'T_HTML',        'T_ECHO',      
  'T_FOR',         'T_LPARENT',     'T_RPARENT',     'T_EMPTY',     
  'T_END',         'T_ENDFOR',      'T_IF',          'T_ELIF',      
  'T_ELSE',        'T_ENDIF',       'T_TAG',         'T_TAG_BLOCK', 
  'T_SET',         'T_ASSIGN',      'T_DOLLAR',      'T_AT',        
  'T_BRACKET_CLOSE',  'T_CURLY_OPEN',  'T_CURLY_CLOSE',  'T_BOOL',      
  'T_NUMBER',      'T_STRING',      'T_ALPHA',       'error',       
  'start',         'body',          'code',          'expr',        
  'for_dest',      'for_source',    'for_end',       'term',        
  'variable',      'if_end',        'arguments_list',  'var_part',    
  'alpha',         'term_simple',   'filters',       'json',        
  'args',          'json_obj',      'json_arr',      'filter',      
  'arguments',     'term_list',   
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= body",
 /*   1 */ "body ::= body code",
 /*   2 */ "body ::=",
 /*   3 */ "code ::= T_HTML",
 /*   4 */ "code ::= T_ECHO expr",
 /*   5 */ "code ::= T_FOR for_dest T_IN for_source body for_end",
 /*   6 */ "for_source ::= term",
 /*   7 */ "for_source ::= T_LPARENT expr T_RPARENT",
 /*   8 */ "for_dest ::= variable",
 /*   9 */ "for_dest ::= variable T_COMMA variable",
 /*  10 */ "for_end ::= T_EMPTY body T_END|T_ENDFOR",
 /*  11 */ "for_end ::= T_END|T_ENDFOR",
 /*  12 */ "code ::= T_IF expr body if_end",
 /*  13 */ "if_end ::= T_ELIF expr body if_end",
 /*  14 */ "if_end ::= T_ELSE body T_END|T_ENDIF",
 /*  15 */ "if_end ::= T_END|T_ENDIF",
 /*  16 */ "code ::= T_TAG arguments_list",
 /*  17 */ "code ::= T_TAG_BLOCK arguments_list body T_END",
 /*  18 */ "code ::= T_SET variable T_ASSIGN expr",
 /*  19 */ "variable ::= variable var_part",
 /*  20 */ "variable ::= variable T_OBJ|T_DOT variable",
 /*  21 */ "variable ::= alpha",
 /*  22 */ "variable ::= T_DOLLAR alpha",
 /*  23 */ "variable ::= T_AT alpha",
 /*  24 */ "var_part ::= T_BRACKET_OPEN expr T_BRACKET_CLOSE",
 /*  25 */ "var_part ::= T_CURLY_OPEN expr T_CURLY_CLOSE",
 /*  26 */ "expr ::= T_NOT expr",
 /*  27 */ "expr ::= expr T_AND expr",
 /*  28 */ "expr ::= expr T_OR expr",
 /*  29 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE expr",
 /*  30 */ "expr ::= expr T_IN expr",
 /*  31 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  32 */ "expr ::= expr T_PLUS|T_MINUS|T_CONCAT expr",
 /*  33 */ "expr ::= expr T_BITWISE expr",
 /*  34 */ "expr ::= expr T_PIPE expr",
 /*  35 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  36 */ "expr ::= term",
 /*  37 */ "term ::= term_simple T_FILTER_PIPE filters",
 /*  38 */ "term ::= term_simple",
 /*  39 */ "term_simple ::= json",
 /*  40 */ "term_simple ::= T_BOOL",
 /*  41 */ "term_simple ::= variable",
 /*  42 */ "term_simple ::= T_NUMBER",
 /*  43 */ "term_simple ::= T_STRING",
 /*  44 */ "term_simple ::= variable T_LPARENT args T_RPARENT",
 /*  45 */ "alpha ::= T_ALPHA",
 /*  46 */ "json ::= T_CURLY_OPEN json_obj T_CURLY_CLOSE",
 /*  47 */ "json ::= T_BRACKET_OPEN json_arr T_BRACKET_CLOSE",
 /*  48 */ "json_obj ::= json_obj T_COMMA json_obj",
 /*  49 */ "json_obj ::= term_simple T_COLON expr",
 /*  50 */ "json_arr ::= json_arr T_COMMA expr",
 /*  51 */ "json_arr ::= expr",
 /*  52 */ "filters ::= filters T_FILTER_PIPE filter",
 /*  53 */ "filters ::= filter",
 /*  54 */ "filter ::= alpha arguments",
 /*  55 */ "arguments_list ::=",
 /*  56 */ "arguments_list ::= T_LPARENT args T_RPARENT",
 /*  57 */ "arguments_list ::= term_list",
 /*  58 */ "term_list ::= term_list term_simple",
 /*  59 */ "term_list ::= term_simple",
 /*  60 */ "arguments ::=",
 /*  61 */ "arguments ::= T_COLON term_simple",
 /*  62 */ "arguments ::= T_LPARENT args T_RPARENT",
 /*  63 */ "args ::= args T_COMMA args",
 /*  64 */ "args ::= expr",
 /*  65 */ "args ::=",
    );

    /**
     * This function returns the symbolic name associated with a token
     * value.
     * @param int
     * @return string
     */
    function tokenName($tokenType)
    {
        if ($tokenType === 0) {
            return 'End of Input';
        }
        if ($tokenType > 0 && $tokenType < count(self::$yyTokenName)) {
            return self::$yyTokenName[$tokenType];
        } else {
            return "Unknown";
        }
    }

    /**
     * The following function deletes the value associated with a
     * symbol.  The symbol can be either a terminal or nonterminal.
     * @param int the symbol code
     * @param mixed the symbol's value
     */
    static function yy_destructor($yymajor, $yypminor)
    {
        switch ($yymajor) {
        /* Here is inserted the actions which take place when a
        ** terminal or non-terminal is destroyed.  This can happen
        ** when the symbol is popped from the stack during a
        ** reduce or during error processing or when a parser is 
        ** being destroyed before it is finished parsing.
        **
        ** Note: during a reduce, the only symbols destroyed are those
        ** which appear on the RHS of the rule, but which are not used
        ** inside the C code.
        */
            default:  break;   /* If no destructor action specified: do nothing */
        }
    }

    /**
     * Pop the parser's stack once.
     *
     * If there is a destructor routine associated with the token which
     * is popped from the stack, then call it.
     *
     * Return the major token number for the symbol popped.
     * @param Haanga2_yyParser
     * @return int
     */
    function yy_pop_parser_stack()
    {
        if (!count($this->yystack)) {
            return;
        }
        $yytos = array_pop($this->yystack);
        if (self::$yyTraceFILE && $this->yyidx >= 0) {
            fwrite(self::$yyTraceFILE,
                self::$yyTracePrompt . 'Popping ' . self::$yyTokenName[$yytos->major] .
                    "\n");
        }
        $yymajor = $yytos->major;
        self::yy_destructor($yymajor, $yytos->minor);
        $this->yyidx--;
        return $yymajor;
    }

    /**
     * Deallocate and destroy a parser.  Destructors are all called for
     * all stack elements before shutting the parser down.
     */
    function __destruct()
    {
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        if (is_resource(self::$yyTraceFILE)) {
            fclose(self::$yyTraceFILE);
        }
    }

    /**
     * Based on the current state and parser stack, get a list of all
     * possible lookahead tokens
     * @param int
     * @return array
     */
    function yy_get_expected_tokens($token)
    {
        $state = $this->yystack[$this->yyidx]->stateno;
        $expected = self::$yyExpectedTokens[$state];
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return $expected;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return array_unique($expected);
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate])) {
                        $expected += self::$yyExpectedTokens[$nextstate];
                            if (in_array($token,
                                  self::$yyExpectedTokens[$nextstate], true)) {
                            $this->yyidx = $yyidx;
                            $this->yystack = $stack;
                            return array_unique($expected);
                        }
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Haanga2_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return array_unique($expected);
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return $expected;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        return array_unique($expected);
    }

    /**
     * Based on the parser state and current parser stack, determine whether
     * the lookahead token is possible.
     * 
     * The parser will convert the token value to an error token if not.  This
     * catches some unusual edge cases where the parser would fail.
     * @param int
     * @return bool
     */
    function yy_is_expected_token($token)
    {
        if ($token === 0) {
            return true; // 0 is not part of this
        }
        $state = $this->yystack[$this->yyidx]->stateno;
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return true;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return true;
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate]) &&
                          in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        return true;
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Haanga2_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        if (!$token) {
                            // end of input: this is valid
                            return true;
                        }
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return false;
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return true;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        $this->yyidx = $yyidx;
        $this->yystack = $stack;
        return true;
    }

    /**
     * Find the appropriate action for a parser given the terminal
     * look-ahead token iLookAhead.
     *
     * If the look-ahead token is YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return YY_NO_ACTION.
     * @param int The look-ahead token
     */
    function yy_find_shift_action($iLookAhead)
    {
        $stateno = $this->yystack[$this->yyidx]->stateno;
     
        /* if ($this->yyidx < 0) return self::YY_NO_ACTION;  */
        if (!isset(self::$yy_shift_ofst[$stateno])) {
            // no shift actions
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_shift_ofst[$stateno];
        if ($i === self::YY_SHIFT_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            if (count(self::$yyFallback) && $iLookAhead < count(self::$yyFallback)
                   && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
                if (self::$yyTraceFILE) {
                    fwrite(self::$yyTraceFILE, self::$yyTracePrompt . "FALLBACK " .
                        self::$yyTokenName[$iLookAhead] . " => " .
                        self::$yyTokenName[$iFallback] . "\n");
                }
                return $this->yy_find_shift_action($iFallback);
            }
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Find the appropriate action for a parser given the non-terminal
     * look-ahead token $iLookAhead.
     *
     * If the look-ahead token is self::YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return self::YY_NO_ACTION.
     * @param int Current state number
     * @param int The look-ahead token
     */
    function yy_find_reduce_action($stateno, $iLookAhead)
    {
        /* $stateno = $this->yystack[$this->yyidx]->stateno; */

        if (!isset(self::$yy_reduce_ofst[$stateno])) {
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_reduce_ofst[$stateno];
        if ($i == self::YY_REDUCE_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Perform a shift action.
     * @param int The new state to shift in
     * @param int The major token to shift in
     * @param mixed the minor token to shift in
     */
    function yy_shift($yyNewState, $yyMajor, $yypMinor)
    {
        $this->yyidx++;
        if ($this->yyidx >= self::YYSTACKDEPTH) {
            $this->yyidx--;
            if (self::$yyTraceFILE) {
                fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);
            }
            while ($this->yyidx >= 0) {
                $this->yy_pop_parser_stack();
            }
            /* Here code is inserted which will execute if the parser
            ** stack ever overflows */
            return;
        }
        $yytos = new Haanga2_yyStackEntry;
        $yytos->stateno = $yyNewState;
        $yytos->major = $yyMajor;
        $yytos->minor = $yypMinor;
        array_push($this->yystack, $yytos);
        if (self::$yyTraceFILE && $this->yyidx > 0) {
            fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt,
                $yyNewState);
            fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
            for ($i = 1; $i <= $this->yyidx; $i++) {
                fprintf(self::$yyTraceFILE, " %s",
                    self::$yyTokenName[$this->yystack[$i]->major]);
            }
            fwrite(self::$yyTraceFILE,"\n");
        }
    }

    /**
     * The following table contains information about every rule that
     * is used during the reduce.
     *
     * <pre>
     * array(
     *  array(
     *   int $lhs;         Symbol on the left-hand side of the rule
     *   int $nrhs;     Number of right-hand side symbols in the rule
     *  ),...
     * );
     * </pre>
     */
    static public $yyRuleInfo = array(
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 2 ),
  array( 'lhs' => 53, 'rhs' => 0 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 2 ),
  array( 'lhs' => 54, 'rhs' => 6 ),
  array( 'lhs' => 57, 'rhs' => 1 ),
  array( 'lhs' => 57, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 58, 'rhs' => 3 ),
  array( 'lhs' => 58, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 4 ),
  array( 'lhs' => 61, 'rhs' => 4 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 2 ),
  array( 'lhs' => 54, 'rhs' => 4 ),
  array( 'lhs' => 54, 'rhs' => 4 ),
  array( 'lhs' => 60, 'rhs' => 2 ),
  array( 'lhs' => 60, 'rhs' => 3 ),
  array( 'lhs' => 60, 'rhs' => 1 ),
  array( 'lhs' => 60, 'rhs' => 2 ),
  array( 'lhs' => 60, 'rhs' => 2 ),
  array( 'lhs' => 63, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 59, 'rhs' => 3 ),
  array( 'lhs' => 59, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 4 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 66, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 2 ),
  array( 'lhs' => 62, 'rhs' => 0 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 62, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 0 ),
  array( 'lhs' => 72, 'rhs' => 2 ),
  array( 'lhs' => 72, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 0 ),
    );

    /**
     * The following table contains a mapping of reduce action to method name
     * that handles the reduction.
     * 
     * If a rule is not set, it has no handler.
     */
    static public $yyReduceMap = array(
        0 => 0,
        1 => 1,
        2 => 2,
        11 => 2,
        15 => 2,
        60 => 2,
        65 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        36 => 6,
        38 => 6,
        41 => 6,
        45 => 6,
        57 => 6,
        7 => 7,
        10 => 7,
        14 => 7,
        47 => 7,
        56 => 7,
        62 => 7,
        8 => 8,
        51 => 8,
        53 => 8,
        59 => 8,
        61 => 8,
        64 => 8,
        9 => 9,
        12 => 12,
        13 => 13,
        16 => 16,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
        26 => 26,
        27 => 27,
        28 => 27,
        29 => 27,
        31 => 27,
        32 => 27,
        33 => 27,
        30 => 30,
        34 => 34,
        35 => 35,
        37 => 37,
        39 => 39,
        40 => 40,
        42 => 42,
        43 => 43,
        44 => 44,
        46 => 46,
        48 => 48,
        49 => 49,
        50 => 50,
        52 => 50,
        54 => 54,
        58 => 58,
        63 => 63,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 86 "lib/Haanga2/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1292 "lib/Haanga2/Compiler/Parser.php"
#line 88 "lib/Haanga2/Compiler/Parser.y"
    function yy_r1(){ $this->yystack[$this->yyidx + -1]->minor[] = $this->yystack[$this->yyidx + 0]->minor; $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1295 "lib/Haanga2/Compiler/Parser.php"
#line 89 "lib/Haanga2/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1298 "lib/Haanga2/Compiler/Parser.php"
#line 91 "lib/Haanga2/Compiler/Parser.y"
    function yy_r3(){ $this->_retvalue = new DoPrint(new Term\String($this->yystack[$this->yyidx + 0]->minor));     }
#line 1301 "lib/Haanga2/Compiler/Parser.php"
#line 93 "lib/Haanga2/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = new DoPrint($this->yystack[$this->yyidx + 0]->minor);     }
#line 1304 "lib/Haanga2/Compiler/Parser.php"
#line 96 "lib/Haanga2/Compiler/Parser.y"
    function yy_r5(){ $this->_retvalue = new DoFor($this->yystack[$this->yyidx + -4]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1307 "lib/Haanga2/Compiler/Parser.php"
#line 97 "lib/Haanga2/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1310 "lib/Haanga2/Compiler/Parser.php"
#line 98 "lib/Haanga2/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1313 "lib/Haanga2/Compiler/Parser.php"
#line 99 "lib/Haanga2/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1316 "lib/Haanga2/Compiler/Parser.php"
#line 100 "lib/Haanga2/Compiler/Parser.y"
    function yy_r9(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -2]->minor);     }
#line 1319 "lib/Haanga2/Compiler/Parser.php"
#line 106 "lib/Haanga2/Compiler/Parser.y"
    function yy_r12(){ $this->_retvalue = new DoIf($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1322 "lib/Haanga2/Compiler/Parser.php"
#line 107 "lib/Haanga2/Compiler/Parser.y"
    function yy_r13(){ $this->_retvalue = array(new DoIf($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor));     }
#line 1325 "lib/Haanga2/Compiler/Parser.php"
#line 113 "lib/Haanga2/Compiler/Parser.y"
    function yy_r16(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1328 "lib/Haanga2/Compiler/Parser.php"
#line 114 "lib/Haanga2/Compiler/Parser.y"
    function yy_r17(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1331 "lib/Haanga2/Compiler/Parser.php"
#line 118 "lib/Haanga2/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = new DefVariable($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1334 "lib/Haanga2/Compiler/Parser.php"
#line 122 "lib/Haanga2/Compiler/Parser.y"
    function yy_r19(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->yystack[$this->yyidx + -1]->minor->addPart($this->yystack[$this->yyidx + 0]->minor[1], $this->yystack[$this->yyidx + 0]->minor[0]);     }
#line 1337 "lib/Haanga2/Compiler/Parser.php"
#line 123 "lib/Haanga2/Compiler/Parser.y"
    function yy_r20(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue->addPart($this->yystack[$this->yyidx + 0]->minor, T_OBJECT);     }
#line 1340 "lib/Haanga2/Compiler/Parser.php"
#line 124 "lib/Haanga2/Compiler/Parser.y"
    function yy_r21(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor);     }
#line 1343 "lib/Haanga2/Compiler/Parser.php"
#line 125 "lib/Haanga2/Compiler/Parser.y"
    function yy_r22(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, Variable::T_OBJECT);     }
#line 1346 "lib/Haanga2/Compiler/Parser.php"
#line 126 "lib/Haanga2/Compiler/Parser.y"
    function yy_r23(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, Variable::T_ARRAY);     }
#line 1349 "lib/Haanga2/Compiler/Parser.php"
#line 128 "lib/Haanga2/Compiler/Parser.y"
    function yy_r24(){ $this->_retvalue = array(Variable::T_ARRAY, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1352 "lib/Haanga2/Compiler/Parser.php"
#line 129 "lib/Haanga2/Compiler/Parser.y"
    function yy_r25(){ $this->_retvalue = array(Variable::T_OBJECT, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1355 "lib/Haanga2/Compiler/Parser.php"
#line 134 "lib/Haanga2/Compiler/Parser.y"
    function yy_r26(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + 0]->minor, 'not');     }
#line 1358 "lib/Haanga2/Compiler/Parser.php"
#line 135 "lib/Haanga2/Compiler/Parser.y"
    function yy_r27(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1361 "lib/Haanga2/Compiler/Parser.php"
#line 138 "lib/Haanga2/Compiler/Parser.y"
    function yy_r30(){ $this->_retvalue = new Expr\In($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1364 "lib/Haanga2/Compiler/Parser.php"
#line 142 "lib/Haanga2/Compiler/Parser.y"
    function yy_r34(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @X, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1367 "lib/Haanga2/Compiler/Parser.php"
#line 143 "lib/Haanga2/Compiler/Parser.y"
    function yy_r35(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -1]->minor);     }
#line 1370 "lib/Haanga2/Compiler/Parser.php"
#line 148 "lib/Haanga2/Compiler/Parser.y"
    function yy_r37(){ $this->_retvalue = new Term\Filter($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1373 "lib/Haanga2/Compiler/Parser.php"
#line 150 "lib/Haanga2/Compiler/Parser.y"
    function yy_r39(){ $this->_retvalue = new Term\Json($this->yystack[$this->yyidx + 0]->minor);     }
#line 1376 "lib/Haanga2/Compiler/Parser.php"
#line 151 "lib/Haanga2/Compiler/Parser.y"
    function yy_r40(){ $this->_retvalue = new Term\Boolean($this->yystack[$this->yyidx + 0]->minor);     }
#line 1379 "lib/Haanga2/Compiler/Parser.php"
#line 153 "lib/Haanga2/Compiler/Parser.y"
    function yy_r42(){ $this->_retvalue = new Term\Number($this->yystack[$this->yyidx + 0]->minor);     }
#line 1382 "lib/Haanga2/Compiler/Parser.php"
#line 154 "lib/Haanga2/Compiler/Parser.y"
    function yy_r43(){ $this->_retvalue = new Term\String($this->yystack[$this->yyidx + 0]->minor) ;     }
#line 1385 "lib/Haanga2/Compiler/Parser.php"
#line 155 "lib/Haanga2/Compiler/Parser.y"
    function yy_r44(){ $this->_retvalue = new Method($this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1388 "lib/Haanga2/Compiler/Parser.php"
#line 161 "lib/Haanga2/Compiler/Parser.y"
    function yy_r46(){ $this->_retvalue  = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1391 "lib/Haanga2/Compiler/Parser.php"
#line 164 "lib/Haanga2/Compiler/Parser.y"
    function yy_r48(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->yystack[$this->yyidx + -2]->minor[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1394 "lib/Haanga2/Compiler/Parser.php"
#line 165 "lib/Haanga2/Compiler/Parser.y"
    function yy_r49(){ $this->_retvalue = array('key' => $this->yystack[$this->yyidx + -2]->minor, 'value' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1397 "lib/Haanga2/Compiler/Parser.php"
#line 167 "lib/Haanga2/Compiler/Parser.y"
    function yy_r50(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1400 "lib/Haanga2/Compiler/Parser.php"
#line 174 "lib/Haanga2/Compiler/Parser.y"
    function yy_r54(){ $this->_retvalue = new Filter($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1403 "lib/Haanga2/Compiler/Parser.php"
#line 181 "lib/Haanga2/Compiler/Parser.y"
    function yy_r58(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1406 "lib/Haanga2/Compiler/Parser.php"
#line 188 "lib/Haanga2/Compiler/Parser.y"
    function yy_r63(){ $this->_retvalue = array_merge($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1409 "lib/Haanga2/Compiler/Parser.php"

    /**
     * placeholder for the left hand side in a reduce operation.
     * 
     * For a parser with a rule like this:
     * <pre>
     * rule(A) ::= B. { A = 1; }
     * </pre>
     * 
     * The parser will translate to something like:
     * 
     * <code>
     * function yy_r0(){$this->_retvalue = 1;}
     * </code>
     */
    private $_retvalue;

    /**
     * Perform a reduce action and the shift that must immediately
     * follow the reduce.
     * 
     * For a rule such as:
     * 
     * <pre>
     * A ::= B blah C. { dosomething(); }
     * </pre>
     * 
     * This function will first call the action, if any, ("dosomething();" in our
     * example), and then it will pop three states from the stack,
     * one for each entry on the right-hand side of the expression
     * (B, blah, and C in our example rule), and then push the result of the action
     * back on to the stack with the resulting state reduced to (as described in the .out
     * file)
     * @param int Number of the rule by which to reduce
     */
    function yy_reduce($yyruleno)
    {
        //int $yygoto;                     /* The next state */
        //int $yyact;                      /* The next action */
        //mixed $yygotominor;        /* The LHS of the rule reduced */
        //Haanga2_yyStackEntry $yymsp;            /* The top of the parser's stack */
        //int $yysize;                     /* Amount to pop the stack */
        $yymsp = $this->yystack[$this->yyidx];
        if (self::$yyTraceFILE && $yyruleno >= 0 
              && $yyruleno < count(self::$yyRuleName)) {
            fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
                self::$yyTracePrompt, $yyruleno,
                self::$yyRuleName[$yyruleno]);
        }

        $this->_retvalue = $yy_lefthand_side = null;
        if (array_key_exists($yyruleno, self::$yyReduceMap)) {
            // call the action
            $this->_retvalue = null;
            $this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
            $yy_lefthand_side = $this->_retvalue;
        }
        $yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
        $yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
        $this->yyidx -= $yysize;
        for ($i = $yysize; $i; $i--) {
            // pop all of the right-hand side parameters
            array_pop($this->yystack);
        }
        $yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
        if ($yyact < self::YYNSTATE) {
            /* If we are not debugging and the reduce action popped at least
            ** one element off the stack, then we can push the new element back
            ** onto the stack here, and skip the stack overflow test in yy_shift().
            ** That gives a significant speed improvement. */
            if (!self::$yyTraceFILE && $yysize) {
                $this->yyidx++;
                $x = new Haanga2_yyStackEntry;
                $x->stateno = $yyact;
                $x->major = $yygoto;
                $x->minor = $yy_lefthand_side;
                $this->yystack[$this->yyidx] = $x;
            } else {
                $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
            }
        } elseif ($yyact == self::YYNSTATE + self::YYNRULE + 1) {
            $this->yy_accept();
        }
    }

    /**
     * The following code executes when the parse fails
     * 
     * Code from %parse_fail is inserted here
     */
    function yy_parse_failed()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser fails */
    }

    /**
     * The following code executes when a syntax error first occurs.
     * 
     * %syntax_error code is inserted here
     * @param int The major type of the error token
     * @param mixed The minor type of the error token
     */
    function yy_syntax_error($yymajor, $TOKEN)
    {
#line 78 "lib/Haanga2/Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. ')');
#line 1529 "lib/Haanga2/Compiler/Parser.php"
    }

    /**
     * The following is executed when the parser accepts
     * 
     * %parse_accept code is inserted here
     */
    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser accepts */
#line 61 "lib/Haanga2/Compiler/Parser.y"

#line 1550 "lib/Haanga2/Compiler/Parser.php"
    }

    /**
     * The main parser program.
     * 
     * The first argument is the major token number.  The second is
     * the token value string as scanned from the input.
     *
     * @param int   $yymajor      the token number
     * @param mixed $yytokenvalue the token value
     * @param mixed ...           any extra arguments that should be passed to handlers
     *
     * @return void
     */
    function doParse($yymajor, $yytokenvalue)
    {
//        $yyact;            /* The parser action. */
//        $yyendofinput;     /* True if we are at the end of input */
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        /* (re)initialize the parser, if necessary */
        if ($this->yyidx === null || $this->yyidx < 0) {
            /* if ($yymajor == 0) return; // not sure why this was here... */
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new Haanga2_yyStackEntry;
            $x->stateno = 0;
            $x->major = 0;
            $this->yystack = array();
            array_push($this->yystack, $x);
        }
        $yyendofinput = ($yymajor==0);
        
        if (self::$yyTraceFILE) {
            fprintf(
                self::$yyTraceFILE,
                "%sInput %s\n",
                self::$yyTracePrompt,
                self::$yyTokenName[$yymajor]
            );
        }
        
        do {
            $yyact = $this->yy_find_shift_action($yymajor);
            if ($yymajor < self::YYERRORSYMBOL
                && !$this->yy_is_expected_token($yymajor)
            ) {
                // force a syntax error
                $yyact = self::YY_ERROR_ACTION;
            }
            if ($yyact < self::YYNSTATE) {
                $this->yy_shift($yyact, $yymajor, $yytokenvalue);
                $this->yyerrcnt--;
                if ($yyendofinput && $this->yyidx >= 0) {
                    $yymajor = 0;
                } else {
                    $yymajor = self::YYNOCODE;
                }
            } elseif ($yyact < self::YYNSTATE + self::YYNRULE) {
                $this->yy_reduce($yyact - self::YYNSTATE);
            } elseif ($yyact == self::YY_ERROR_ACTION) {
                if (self::$yyTraceFILE) {
                    fprintf(
                        self::$yyTraceFILE,
                        "%sSyntax Error!\n",
                        self::$yyTracePrompt
                    );
                }
                if (self::YYERRORSYMBOL) {
                    /* A syntax error has occurred.
                    ** The response to an error depends upon whether or not the
                    ** grammar defines an error token "ERROR".  
                    **
                    ** This is what we do if the grammar does define ERROR:
                    **
                    **  * Call the %syntax_error function.
                    **
                    **  * Begin popping the stack until we enter a state where
                    **    it is legal to shift the error symbol, then shift
                    **    the error symbol.
                    **
                    **  * Set the error count to three.
                    **
                    **  * Begin accepting and shifting new tokens.  No new error
                    **    processing will occur until three tokens have been
                    **    shifted successfully.
                    **
                    */
                    if ($this->yyerrcnt < 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $yymx = $this->yystack[$this->yyidx]->major;
                    if ($yymx == self::YYERRORSYMBOL || $yyerrorhit ) {
                        if (self::$yyTraceFILE) {
                            fprintf(
                                self::$yyTraceFILE,
                                "%sDiscard input token %s\n",
                                self::$yyTracePrompt,
                                self::$yyTokenName[$yymajor]
                            );
                        }
                        $this->yy_destructor($yymajor, $yytokenvalue);
                        $yymajor = self::YYNOCODE;
                    } else {
                        while ($this->yyidx >= 0
                            && $yymx != self::YYERRORSYMBOL
                            && ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE
                        ) {
                            $this->yy_pop_parser_stack();
                        }
                        if ($this->yyidx < 0 || $yymajor==0) {
                            $this->yy_destructor($yymajor, $yytokenvalue);
                            $this->yy_parse_failed();
                            $yymajor = self::YYNOCODE;
                        } elseif ($yymx != self::YYERRORSYMBOL) {
                            $u2 = 0;
                            $this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
                        }
                    }
                    $this->yyerrcnt = 3;
                    $yyerrorhit = 1;
                } else {
                    /* YYERRORSYMBOL is not defined */
                    /* This is what we do if the grammar does not define ERROR:
                    **
                    **  * Report an error message, and throw away the input token.
                    **
                    **  * If the input token is $, then fail the parse.
                    **
                    ** As before, subsequent error messages are suppressed until
                    ** three input tokens have been successfully shifted.
                    */
                    if ($this->yyerrcnt <= 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $this->yyerrcnt = 3;
                    $this->yy_destructor($yymajor, $yytokenvalue);
                    if ($yyendofinput) {
                        $this->yy_parse_failed();
                    }
                    $yymajor = self::YYNOCODE;
                }
            } else {
                $this->yy_accept();
                $yymajor = self::YYNOCODE;
            }            
        } while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
    }
}
