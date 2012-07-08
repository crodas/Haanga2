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
    const T_BRACKETS_OPEN                =  9;
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
    const T_BRACKETS_CLOSE               = 44;
    const T_BOOL                         = 45;
    const T_NUMBER                       = 46;
    const T_STRING                       = 47;
    const T_ALPHA                        = 48;
    const T_CURLY_OPEN                   = 49;
    const T_CURLY_CLOSE                  = 50;
    const YY_NO_ACTION = 188;
    const YY_ACCEPT_ACTION = 187;
    const YY_ERROR_ACTION = 186;

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
    const YY_SZ_ACTTAB = 575;
static public $yy_action = array(
 /*     0 */    19,    9,   13,   13,   13,   12,   14,   16,    6,    6,
 /*    10 */     6,    6,    6,    6,   10,   11,   11,   11,   13,   13,
 /*    20 */    13,   12,   14,    6,    6,    6,    6,    6,    6,   10,
 /*    30 */    11,   11,   11,   13,   13,   13,   12,   14,   25,   56,
 /*    40 */   187,   45,   84,   90,   70,   19,    9,   93,   79,   69,
 /*    50 */   120,   75,   93,    6,    6,    6,    6,    6,    6,   10,
 /*    60 */    11,   11,   11,   13,   13,   13,   12,   14,   19,    9,
 /*    70 */    37,   37,   15,   96,    3,   39,    6,    6,    6,    6,
 /*    80 */     6,    6,   10,   11,   11,   11,   13,   13,   13,   12,
 /*    90 */    14,   19,    9,   37,   37,   15,   87,   32,  101,    6,
 /*   100 */     6,    6,    6,    6,    6,   10,   11,   11,   11,   13,
 /*   110 */    13,   13,   12,   14,    9,    5,   36,   37,   37,   15,
 /*   120 */   116,    6,    6,    6,    6,    6,    6,   10,   11,   11,
 /*   130 */    11,   13,   13,   13,   12,   14,    6,    6,    6,    6,
 /*   140 */     6,   10,   11,   11,   11,   13,   13,   13,   12,   14,
 /*   150 */    94,   20,   31,   21,   71,   91,   92,   93,   18,   23,
 /*   160 */    51,   92,   24,   26,   38,    8,   30,   12,   14,   94,
 /*   170 */    20,   31,   97,    2,   52,   98,   98,   18,  100,   48,
 /*   180 */    47,   24,   26,   38,    2,  100,   94,   20,   31,   44,
 /*   190 */     4,  103,  117,    7,   18,   95,    2,  117,   24,   26,
 /*   200 */    38,   46,  104,   81,    1,   95,   48,   47,  115,  119,
 /*   210 */   112,  111,  100,   27,  139,   33,   22,   48,   47,    2,
 /*   220 */   119,  112,  111,  100,   27,   34,   37,   37,   15,   48,
 /*   230 */    47,   28,  119,  112,  111,  100,   27,   94,   20,   31,
 /*   240 */    46,   35,   42,  110,  110,   18,    3,  114,   43,   24,
 /*   250 */    26,   38,   48,   47,    3,  119,  112,  111,  100,   27,
 /*   260 */    17,   11,   11,   11,   13,   13,   13,   12,   14,  139,
 /*   270 */   109,   94,   20,   31,  139,  105,  139,   82,  102,   18,
 /*   280 */    94,   20,   31,   24,   26,   38,  139,   85,   18,  139,
 /*   290 */    93,   56,   24,   26,   38,   90,   70,  139,  139,   93,
 /*   300 */    79,   56,  120,  108,   95,   90,   70,  139,  121,   93,
 /*   310 */    79,   59,  120,   72,   80,   90,   70,   95,   68,   93,
 /*   320 */    79,   93,  120,   56,  118,   76,  139,   90,   70,  139,
 /*   330 */   139,   93,   79,   83,  120,   73,  139,   90,   70,  139,
 /*   340 */   139,   93,   79,  139,  120,  139,  139,   77,  139,  139,
 /*   350 */   139,   90,   70,  139,  139,   93,   79,   55,  120,  139,
 /*   360 */   139,   90,   70,  139,  139,   93,   79,   86,  120,  139,
 /*   370 */   139,   90,   70,  139,  139,   93,   79,   50,  120,   99,
 /*   380 */    70,  139,  139,   93,   79,  139,  120,   62,  139,  139,
 /*   390 */   139,   90,   70,  139,  139,   93,   79,   54,  120,  139,
 /*   400 */   139,   90,   70,  139,  139,   93,   79,   65,  120,  139,
 /*   410 */   139,   90,   70,  139,  139,   93,   79,   61,  120,  139,
 /*   420 */   139,   90,   70,  139,  139,   93,   79,   64,  120,  139,
 /*   430 */   139,   90,   70,  139,  139,   93,   79,  139,  120,   66,
 /*   440 */   139,  139,  139,   90,   70,  139,  139,   93,   79,  139,
 /*   450 */   120,   67,  139,  139,  139,   90,   70,  139,  139,   93,
 /*   460 */    79,   58,  120,  139,  139,   90,   70,  139,  139,   93,
 /*   470 */    79,   41,  120,  139,  139,   90,   70,  139,  139,   93,
 /*   480 */    79,   40,  120,  139,  139,   90,   70,  139,  139,   93,
 /*   490 */    79,   63,  120,  139,  139,   90,   70,  139,  139,   93,
 /*   500 */    79,  139,  120,   60,  139,  139,  139,   90,   70,  139,
 /*   510 */   139,   93,   79,  139,  120,   57,  139,  139,  139,   90,
 /*   520 */    70,  139,  139,   93,   79,  139,  120,   70,  139,  113,
 /*   530 */    93,   89,   53,  120,  139,  139,   90,   70,  139,   29,
 /*   540 */    93,   79,   70,  120,   49,   93,   89,   70,  120,  139,
 /*   550 */    93,   78,  139,  120,   29,   74,   70,  139,  139,   93,
 /*   560 */    78,  139,  120,   70,  106,  139,   93,  107,   70,  120,
 /*   570 */   139,   93,   88,  139,  120,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,    3,   20,   21,   22,   23,   24,    5,   10,   11,
 /*    10 */    12,   13,   14,   15,   16,   17,   18,   19,   20,   21,
 /*    20 */    22,   23,   24,   10,   11,   12,   13,   14,   15,   16,
 /*    30 */    17,   18,   19,   20,   21,   22,   23,   24,   16,   55,
 /*    40 */    52,   53,   44,   59,   60,    2,    3,   63,   64,   60,
 /*    50 */    66,   67,   63,   10,   11,   12,   13,   14,   15,   16,
 /*    60 */    17,   18,   19,   20,   21,   22,   23,   24,    2,    3,
 /*    70 */     7,    8,    9,   30,    6,   25,   10,   11,   12,   13,
 /*    80 */    14,   15,   16,   17,   18,   19,   20,   21,   22,   23,
 /*    90 */    24,    2,    3,    7,    8,    9,   30,   25,   30,   10,
 /*   100 */    11,   12,   13,   14,   15,   16,   17,   18,   19,   20,
 /*   110 */    21,   22,   23,   24,    3,   29,    6,    7,    8,    9,
 /*   120 */    71,   10,   11,   12,   13,   14,   15,   16,   17,   18,
 /*   130 */    19,   20,   21,   22,   23,   24,   11,   12,   13,   14,
 /*   140 */    15,   16,   17,   18,   19,   20,   21,   22,   23,   24,
 /*   150 */    26,   27,   28,    6,   60,   63,   32,   63,   34,   35,
 /*   160 */    36,   37,   38,   39,   40,    1,    5,   23,   24,   26,
 /*   170 */    27,   28,   63,    9,   31,   32,   33,   34,   48,   42,
 /*   180 */    43,   38,   39,   40,    9,   48,   26,   27,   28,   53,
 /*   190 */    29,   44,   32,   29,   34,   54,    9,   37,   38,   39,
 /*   200 */    40,   63,   61,   65,   29,   54,   42,   43,   70,   45,
 /*   210 */    46,   47,   48,   49,   73,   53,   29,   42,   43,    9,
 /*   220 */    45,   46,   47,   48,   49,   53,    7,    8,    9,   42,
 /*   230 */    43,    6,   45,   46,   47,   48,   49,   26,   27,   28,
 /*   240 */    63,   53,   53,   32,   33,   34,    6,   70,   53,   38,
 /*   250 */    39,   40,   42,   43,    6,   45,   46,   47,   48,   49,
 /*   260 */    41,   17,   18,   19,   20,   21,   22,   23,   24,   73,
 /*   270 */    30,   26,   27,   28,   73,   50,   73,   32,   30,   34,
 /*   280 */    26,   27,   28,   38,   39,   40,   73,   60,   34,   73,
 /*   290 */    63,   55,   38,   39,   40,   59,   60,   73,   73,   63,
 /*   300 */    64,   55,   66,   67,   54,   59,   60,   73,   58,   63,
 /*   310 */    64,   55,   66,   67,   56,   59,   60,   54,   60,   63,
 /*   320 */    64,   63,   66,   55,   61,   69,   73,   59,   60,   73,
 /*   330 */    73,   63,   64,   55,   66,   67,   73,   59,   60,   73,
 /*   340 */    73,   63,   64,   73,   66,   73,   73,   55,   73,   73,
 /*   350 */    73,   59,   60,   73,   73,   63,   64,   55,   66,   73,
 /*   360 */    73,   59,   60,   73,   73,   63,   64,   55,   66,   73,
 /*   370 */    73,   59,   60,   73,   73,   63,   64,   57,   66,   59,
 /*   380 */    60,   73,   73,   63,   64,   73,   66,   55,   73,   73,
 /*   390 */    73,   59,   60,   73,   73,   63,   64,   55,   66,   73,
 /*   400 */    73,   59,   60,   73,   73,   63,   64,   55,   66,   73,
 /*   410 */    73,   59,   60,   73,   73,   63,   64,   55,   66,   73,
 /*   420 */    73,   59,   60,   73,   73,   63,   64,   55,   66,   73,
 /*   430 */    73,   59,   60,   73,   73,   63,   64,   73,   66,   55,
 /*   440 */    73,   73,   73,   59,   60,   73,   73,   63,   64,   73,
 /*   450 */    66,   55,   73,   73,   73,   59,   60,   73,   73,   63,
 /*   460 */    64,   55,   66,   73,   73,   59,   60,   73,   73,   63,
 /*   470 */    64,   55,   66,   73,   73,   59,   60,   73,   73,   63,
 /*   480 */    64,   55,   66,   73,   73,   59,   60,   73,   73,   63,
 /*   490 */    64,   55,   66,   73,   73,   59,   60,   73,   73,   63,
 /*   500 */    64,   73,   66,   55,   73,   73,   73,   59,   60,   73,
 /*   510 */    73,   63,   64,   73,   66,   55,   73,   73,   73,   59,
 /*   520 */    60,   73,   73,   63,   64,   73,   66,   60,   73,   62,
 /*   530 */    63,   64,   55,   66,   73,   73,   59,   60,   73,   72,
 /*   540 */    63,   64,   60,   66,   62,   63,   64,   60,   66,   73,
 /*   550 */    63,   64,   73,   66,   72,   68,   60,   73,   73,   63,
 /*   560 */    64,   73,   66,   60,   68,   73,   63,   64,   60,   66,
 /*   570 */    73,   63,   64,   73,   66,
);
    const YY_SHIFT_USE_DFLT = -19;
    const YY_SHIFT_MAX = 81;
    static public $yy_shift_ofst = array(
 /*     0 */   -19,  164,  164,  164,  164,  164,  164,  164,  164,  164,
 /*    10 */   164,  164,  164,  164,  164,  164,  164,  164,  164,  164,
 /*    20 */   164,  164,  164,  164,  175,  187,  175,  210,  210,  210,
 /*    30 */   210,  137,  130,  124,  124,  143,  137,  137,  137,  130,
 /*    40 */    89,   89,  160,  211,  245,  254,  161,  130,  130,  -19,
 /*    50 */   -19,  -19,  -19,   43,   66,   -2,   89,   89,   89,   89,
 /*    60 */    89,   89,   89,  111,   13,  125,  244,  -18,  110,  219,
 /*    70 */    86,   63,   68,  248,  225,  240,  147,  144,    2,   72,
 /*    80 */    22,   50,
);
    const YY_REDUCE_USE_DFLT = -17;
    const YY_REDUCE_MAX = 52;
    static public $yy_reduce_ofst = array(
 /*     0 */   -12,  268,  256,  236,  -16,  246,  352,  342,  332,  372,
 /*    10 */   384,  396,  312,  292,  278,  302,  406,  362,  416,  436,
 /*    20 */   460,  448,  477,  426,  467,  320,  482,  487,  496,  508,
 /*    30 */   503,  258,  138,  263,  141,  250,   94,  227,  -11,  177,
 /*    40 */   162,  172,  151,  151,  151,  151,   49,   92,  109,  136,
 /*    50 */   188,  189,  195,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 2 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 3 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 4 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 5 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 6 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 7 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 8 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 9 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 10 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 11 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 12 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 13 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 14 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 15 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 16 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 17 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 18 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 19 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 20 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 21 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 22 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 23 */ array(1, 9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 24 */ array(9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 25 */ array(9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 26 */ array(9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 27 */ array(9, 42, 43, 45, 46, 47, 48, 49, ),
        /* 28 */ array(9, 42, 43, 45, 46, 47, 48, 49, ),
        /* 29 */ array(9, 42, 43, 45, 46, 47, 48, 49, ),
        /* 30 */ array(9, 42, 43, 45, 46, 47, 48, 49, ),
        /* 31 */ array(42, 43, 48, ),
        /* 32 */ array(48, ),
        /* 33 */ array(26, 27, 28, 32, 34, 35, 36, 37, 38, 39, 40, ),
        /* 34 */ array(26, 27, 28, 32, 34, 35, 36, 37, 38, 39, 40, ),
        /* 35 */ array(26, 27, 28, 31, 32, 33, 34, 38, 39, 40, ),
        /* 36 */ array(42, 43, 48, ),
        /* 37 */ array(42, 43, 48, ),
        /* 38 */ array(42, 43, 48, ),
        /* 39 */ array(48, ),
        /* 40 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 41 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 42 */ array(26, 27, 28, 32, 34, 37, 38, 39, 40, ),
        /* 43 */ array(26, 27, 28, 32, 33, 34, 38, 39, 40, ),
        /* 44 */ array(26, 27, 28, 32, 34, 38, 39, 40, ),
        /* 45 */ array(26, 27, 28, 34, 38, 39, 40, ),
        /* 46 */ array(5, 29, ),
        /* 47 */ array(48, ),
        /* 48 */ array(48, ),
        /* 49 */ array(),
        /* 50 */ array(),
        /* 51 */ array(),
        /* 52 */ array(),
        /* 53 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 30, ),
        /* 54 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 30, ),
        /* 55 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 44, ),
        /* 56 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 57 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 58 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 59 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 60 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 61 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 62 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 63 */ array(3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 64 */ array(10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 65 */ array(11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 66 */ array(17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 67 */ array(20, 21, 22, 23, 24, ),
        /* 68 */ array(6, 7, 8, 9, ),
        /* 69 */ array(7, 8, 9, 41, ),
        /* 70 */ array(7, 8, 9, 29, ),
        /* 71 */ array(7, 8, 9, ),
        /* 72 */ array(6, 30, ),
        /* 73 */ array(6, 30, ),
        /* 74 */ array(6, 50, ),
        /* 75 */ array(6, 30, ),
        /* 76 */ array(6, 44, ),
        /* 77 */ array(23, 24, ),
        /* 78 */ array(5, ),
        /* 79 */ array(25, ),
        /* 80 */ array(16, ),
        /* 81 */ array(25, ),
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(),
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
);
    static public $yy_default = array(
 /*     0 */   124,  185,  186,  185,  185,  185,  186,  186,  186,  186,
 /*    10 */   186,  186,  186,  186,  186,  186,  186,  186,  186,  186,
 /*    20 */   186,  186,  186,  186,  175,  186,  175,  186,  186,  177,
 /*    30 */   186,  186,  186,  186,  186,  186,  186,  186,  186,  186,
 /*    40 */   124,  124,  186,  186,  186,  122,  180,  186,  186,  124,
 /*    50 */   124,  124,  124,  186,  186,  186,  184,  126,  169,  171,
 /*    60 */   170,  140,  146,  147,  148,  149,  150,  152,  130,  186,
 /*    70 */   161,  131,  186,  186,  186,  186,  186,  151,  186,  158,
 /*    80 */   186,  157,  139,  153,  145,  144,  154,  155,  178,  179,
 /*    90 */   156,  143,  137,  141,  125,  123,  129,  142,  133,  128,
 /*   100 */   165,  164,  176,  167,  134,  166,  168,  181,  183,  182,
 /*   110 */   132,  163,  162,  138,  172,  173,  174,  136,  135,  160,
 /*   120 */   159,  127,
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
    const YYNOCODE = 74;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 122;
    const YYNRULE = 64;
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
  'T_OBJ',         'T_BRACKETS_OPEN',  'T_NE',          'T_EQ',        
  'T_GT',          'T_GE',          'T_LT',          'T_LE',        
  'T_IN',          'T_PLUS',        'T_MINUS',       'T_CONCAT',    
  'T_TIMES',       'T_DIV',         'T_MOD',         'T_PIPE',      
  'T_BITWISE',     'T_FILTER_PIPE',  'T_HTML',        'T_ECHO',      
  'T_FOR',         'T_LPARENT',     'T_RPARENT',     'T_EMPTY',     
  'T_END',         'T_ENDFOR',      'T_IF',          'T_ELIF',      
  'T_ELSE',        'T_ENDIF',       'T_TAG',         'T_TAG_BLOCK', 
  'T_SET',         'T_ASSIGN',      'T_DOLLAR',      'T_AT',        
  'T_BRACKETS_CLOSE',  'T_BOOL',        'T_NUMBER',      'T_STRING',    
  'T_ALPHA',       'T_CURLY_OPEN',  'T_CURLY_CLOSE',  'error',       
  'start',         'body',          'code',          'expr',        
  'for_dest',      'for_source',    'for_end',       'term',        
  'variable',      'if_end',        'arguments_list',  'alpha',       
  'term_simple',   'filters',       'json',          'args',        
  'json_obj',      'json_arr',      'filter',        'arguments',   
  'term_list',   
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
 /*  19 */ "variable ::= alpha",
 /*  20 */ "variable ::= T_DOLLAR alpha",
 /*  21 */ "variable ::= T_AT alpha",
 /*  22 */ "variable ::= variable T_DOT|T_OBJ variable",
 /*  23 */ "variable ::= variable T_BRACKETS_OPEN expr T_BRACKETS_CLOSE",
 /*  24 */ "expr ::= T_NOT expr",
 /*  25 */ "expr ::= expr T_AND expr",
 /*  26 */ "expr ::= expr T_OR expr",
 /*  27 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE expr",
 /*  28 */ "expr ::= expr T_IN expr",
 /*  29 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  30 */ "expr ::= expr T_PLUS|T_MINUS|T_CONCAT expr",
 /*  31 */ "expr ::= expr T_BITWISE expr",
 /*  32 */ "expr ::= expr T_PIPE expr",
 /*  33 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  34 */ "expr ::= term",
 /*  35 */ "term ::= term_simple T_FILTER_PIPE filters",
 /*  36 */ "term ::= term_simple",
 /*  37 */ "term_simple ::= json",
 /*  38 */ "term_simple ::= T_BOOL",
 /*  39 */ "term_simple ::= variable",
 /*  40 */ "term_simple ::= T_NUMBER",
 /*  41 */ "term_simple ::= T_STRING",
 /*  42 */ "term_simple ::= variable T_LPARENT args T_RPARENT",
 /*  43 */ "alpha ::= T_ALPHA",
 /*  44 */ "json ::= T_CURLY_OPEN json_obj T_CURLY_CLOSE",
 /*  45 */ "json ::= T_BRACKETS_OPEN json_arr T_BRACKETS_CLOSE",
 /*  46 */ "json_obj ::= json_obj T_COMMA json_obj",
 /*  47 */ "json_obj ::= term_simple T_COLON expr",
 /*  48 */ "json_arr ::= json_arr T_COMMA expr",
 /*  49 */ "json_arr ::= expr",
 /*  50 */ "filters ::= filters T_FILTER_PIPE filter",
 /*  51 */ "filters ::= filter",
 /*  52 */ "filter ::= alpha arguments",
 /*  53 */ "arguments_list ::=",
 /*  54 */ "arguments_list ::= T_LPARENT args T_RPARENT",
 /*  55 */ "arguments_list ::= term_list",
 /*  56 */ "term_list ::= term_list term_simple",
 /*  57 */ "term_list ::= term_simple",
 /*  58 */ "arguments ::=",
 /*  59 */ "arguments ::= T_COLON term_simple",
 /*  60 */ "arguments ::= T_LPARENT args T_RPARENT",
 /*  61 */ "args ::= args T_COMMA args",
 /*  62 */ "args ::= expr",
 /*  63 */ "args ::=",
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
  array( 'lhs' => 60, 'rhs' => 1 ),
  array( 'lhs' => 60, 'rhs' => 2 ),
  array( 'lhs' => 60, 'rhs' => 2 ),
  array( 'lhs' => 60, 'rhs' => 3 ),
  array( 'lhs' => 60, 'rhs' => 4 ),
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
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 4 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 3 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 62, 'rhs' => 0 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 62, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 2 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 0 ),
  array( 'lhs' => 71, 'rhs' => 2 ),
  array( 'lhs' => 71, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 0 ),
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
        58 => 2,
        63 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        34 => 6,
        36 => 6,
        39 => 6,
        43 => 6,
        55 => 6,
        7 => 7,
        10 => 7,
        14 => 7,
        45 => 7,
        54 => 7,
        60 => 7,
        8 => 8,
        49 => 8,
        51 => 8,
        57 => 8,
        59 => 8,
        62 => 8,
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
        26 => 25,
        27 => 25,
        29 => 25,
        30 => 25,
        31 => 25,
        28 => 28,
        32 => 32,
        33 => 33,
        35 => 35,
        37 => 37,
        38 => 38,
        40 => 40,
        41 => 41,
        42 => 42,
        44 => 44,
        46 => 46,
        47 => 47,
        48 => 48,
        50 => 48,
        52 => 52,
        56 => 56,
        61 => 61,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 86 "lib/Haanga2/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1266 "lib/Haanga2/Compiler/Parser.php"
#line 88 "lib/Haanga2/Compiler/Parser.y"
    function yy_r1(){ $this->yystack[$this->yyidx + -1]->minor[] = $this->yystack[$this->yyidx + 0]->minor; $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1269 "lib/Haanga2/Compiler/Parser.php"
#line 89 "lib/Haanga2/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1272 "lib/Haanga2/Compiler/Parser.php"
#line 91 "lib/Haanga2/Compiler/Parser.y"
    function yy_r3(){ $this->_retvalue = new DoPrint(new Term\String($this->yystack[$this->yyidx + 0]->minor));     }
#line 1275 "lib/Haanga2/Compiler/Parser.php"
#line 93 "lib/Haanga2/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = new DoPrint($this->yystack[$this->yyidx + 0]->minor);     }
#line 1278 "lib/Haanga2/Compiler/Parser.php"
#line 96 "lib/Haanga2/Compiler/Parser.y"
    function yy_r5(){ $this->_retvalue = new DoFor($this->yystack[$this->yyidx + -4]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1281 "lib/Haanga2/Compiler/Parser.php"
#line 97 "lib/Haanga2/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1284 "lib/Haanga2/Compiler/Parser.php"
#line 98 "lib/Haanga2/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1287 "lib/Haanga2/Compiler/Parser.php"
#line 99 "lib/Haanga2/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1290 "lib/Haanga2/Compiler/Parser.php"
#line 100 "lib/Haanga2/Compiler/Parser.y"
    function yy_r9(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -2]->minor);     }
#line 1293 "lib/Haanga2/Compiler/Parser.php"
#line 106 "lib/Haanga2/Compiler/Parser.y"
    function yy_r12(){ $this->_retvalue = new DoIf($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1296 "lib/Haanga2/Compiler/Parser.php"
#line 107 "lib/Haanga2/Compiler/Parser.y"
    function yy_r13(){ $this->_retvalue = array(new DoIf($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor));     }
#line 1299 "lib/Haanga2/Compiler/Parser.php"
#line 113 "lib/Haanga2/Compiler/Parser.y"
    function yy_r16(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1302 "lib/Haanga2/Compiler/Parser.php"
#line 114 "lib/Haanga2/Compiler/Parser.y"
    function yy_r17(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1305 "lib/Haanga2/Compiler/Parser.php"
#line 118 "lib/Haanga2/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = new DefVariable($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1308 "lib/Haanga2/Compiler/Parser.php"
#line 122 "lib/Haanga2/Compiler/Parser.y"
    function yy_r19(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor);     }
#line 1311 "lib/Haanga2/Compiler/Parser.php"
#line 123 "lib/Haanga2/Compiler/Parser.y"
    function yy_r20(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, Variable::T_OBJECT);     }
#line 1314 "lib/Haanga2/Compiler/Parser.php"
#line 124 "lib/Haanga2/Compiler/Parser.y"
    function yy_r21(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, Variable::T_ARRAY);     }
#line 1317 "lib/Haanga2/Compiler/Parser.php"
#line 125 "lib/Haanga2/Compiler/Parser.y"
    function yy_r22(){ $this->yystack[$this->yyidx + -2]->minor->addPart($this->yystack[$this->yyidx + 0]->minor, Variable::T_OBJECT); $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor;     }
#line 1320 "lib/Haanga2/Compiler/Parser.php"
#line 126 "lib/Haanga2/Compiler/Parser.y"
    function yy_r23(){ $this->yystack[$this->yyidx + -3]->minor->addPart($this->yystack[$this->yyidx + -1]->minor, Variable::T_ARRAY); $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor ;     }
#line 1323 "lib/Haanga2/Compiler/Parser.php"
#line 130 "lib/Haanga2/Compiler/Parser.y"
    function yy_r24(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + 0]->minor, 'not');     }
#line 1326 "lib/Haanga2/Compiler/Parser.php"
#line 131 "lib/Haanga2/Compiler/Parser.y"
    function yy_r25(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1329 "lib/Haanga2/Compiler/Parser.php"
#line 134 "lib/Haanga2/Compiler/Parser.y"
    function yy_r28(){ $this->_retvalue = new Expr\In($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1332 "lib/Haanga2/Compiler/Parser.php"
#line 138 "lib/Haanga2/Compiler/Parser.y"
    function yy_r32(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @X, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1335 "lib/Haanga2/Compiler/Parser.php"
#line 139 "lib/Haanga2/Compiler/Parser.y"
    function yy_r33(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -1]->minor);     }
#line 1338 "lib/Haanga2/Compiler/Parser.php"
#line 144 "lib/Haanga2/Compiler/Parser.y"
    function yy_r35(){ $this->_retvalue = new Term\Filter($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1341 "lib/Haanga2/Compiler/Parser.php"
#line 146 "lib/Haanga2/Compiler/Parser.y"
    function yy_r37(){ $this->_retvalue = new Term\Json($this->yystack[$this->yyidx + 0]->minor);     }
#line 1344 "lib/Haanga2/Compiler/Parser.php"
#line 147 "lib/Haanga2/Compiler/Parser.y"
    function yy_r38(){ $this->_retvalue = new Term\Boolean($this->yystack[$this->yyidx + 0]->minor);     }
#line 1347 "lib/Haanga2/Compiler/Parser.php"
#line 149 "lib/Haanga2/Compiler/Parser.y"
    function yy_r40(){ $this->_retvalue = new Term\Number($this->yystack[$this->yyidx + 0]->minor);     }
#line 1350 "lib/Haanga2/Compiler/Parser.php"
#line 150 "lib/Haanga2/Compiler/Parser.y"
    function yy_r41(){ $this->_retvalue = new Term\String($this->yystack[$this->yyidx + 0]->minor) ;     }
#line 1353 "lib/Haanga2/Compiler/Parser.php"
#line 151 "lib/Haanga2/Compiler/Parser.y"
    function yy_r42(){ $this->_retvalue = new Method($this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1356 "lib/Haanga2/Compiler/Parser.php"
#line 157 "lib/Haanga2/Compiler/Parser.y"
    function yy_r44(){ $this->_retvalue  = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1359 "lib/Haanga2/Compiler/Parser.php"
#line 160 "lib/Haanga2/Compiler/Parser.y"
    function yy_r46(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->yystack[$this->yyidx + -2]->minor[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1362 "lib/Haanga2/Compiler/Parser.php"
#line 161 "lib/Haanga2/Compiler/Parser.y"
    function yy_r47(){ $this->_retvalue = array('key' => $this->yystack[$this->yyidx + -2]->minor, 'value' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1365 "lib/Haanga2/Compiler/Parser.php"
#line 163 "lib/Haanga2/Compiler/Parser.y"
    function yy_r48(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1368 "lib/Haanga2/Compiler/Parser.php"
#line 170 "lib/Haanga2/Compiler/Parser.y"
    function yy_r52(){ $this->_retvalue = new Filter($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1371 "lib/Haanga2/Compiler/Parser.php"
#line 177 "lib/Haanga2/Compiler/Parser.y"
    function yy_r56(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1374 "lib/Haanga2/Compiler/Parser.php"
#line 184 "lib/Haanga2/Compiler/Parser.y"
    function yy_r61(){ $this->_retvalue = array_merge($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1377 "lib/Haanga2/Compiler/Parser.php"

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
#line 1497 "lib/Haanga2/Compiler/Parser.php"
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

#line 1518 "lib/Haanga2/Compiler/Parser.php"
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
