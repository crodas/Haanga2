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
    Haanga2\Compiler\Parser\DoIf;

#line 143 "lib/Haanga2/Compiler/Parser.php"

// declare_class is output here
#line 46 "lib/Haanga2/Compiler/Parser.y"
 class Haanga2_Compiler_Parser #line 148 "lib/Haanga2/Compiler/Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 47 "lib/Haanga2/Compiler/Parser.y"

    protected $lex;
    protected $file;

    function Error($text)
    {
        throw new \RuntimeException($text);
    }

#line 163 "lib/Haanga2/Compiler/Parser.php"

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
    const YY_NO_ACTION = 183;
    const YY_ACCEPT_ACTION = 182;
    const YY_ERROR_ACTION = 181;

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
    const YY_SZ_ACTTAB = 585;
static public $yy_action = array(
 /*     0 */    21,   14,   10,   10,   10,    7,   11,   18,    6,    6,
 /*    10 */     6,    6,    6,    6,    5,   13,   13,   13,   10,   10,
 /*    20 */    10,    7,   11,   21,   14,   37,   37,   16,  114,  182,
 /*    30 */    44,    6,    6,    6,    6,    6,    6,    5,   13,   13,
 /*    40 */    13,   10,   10,   10,    7,   11,    6,    6,    6,    6,
 /*    50 */     6,    6,    5,   13,   13,   13,   10,   10,   10,    7,
 /*    60 */    11,   36,   37,   37,   16,   83,   31,   70,   21,   14,
 /*    70 */    85,   84,   68,  100,   29,   85,    6,    6,    6,    6,
 /*    80 */     6,    6,    5,   13,   13,   13,   10,   10,   10,    7,
 /*    90 */    11,   21,   14,   89,    7,   11,   88,  108,    3,    6,
 /*   100 */     6,    6,    6,    6,    6,    5,   13,   13,   13,   10,
 /*   110 */    10,   10,    7,   11,   14,   25,   38,   80,   42,   12,
 /*   120 */    85,    6,    6,    6,    6,    6,    6,    5,   13,   13,
 /*   130 */    13,   10,   10,   10,    7,   11,    6,    6,    6,    6,
 /*   140 */     6,    5,   13,   13,   13,   10,   10,   10,    7,   11,
 /*   150 */    87,   19,   30,   37,   37,   16,   91,  110,    9,   20,
 /*   160 */    48,   91,   23,   24,   35,    8,   45,   93,   77,   87,
 /*   170 */    19,   30,   97,    4,   51,   90,   90,    9,  107,   46,
 /*   180 */    47,   23,   24,   35,    4,   93,   94,   17,   89,   87,
 /*   190 */    19,   30,   78,   15,    4,  112,   67,    9,   89,   85,
 /*   200 */   112,   23,   24,   35,    1,  111,   46,   47,   89,   99,
 /*   210 */    98,  102,   93,   27,   22,  113,   95,   46,   47,   45,
 /*   220 */    99,   98,  102,   93,   27,  115,   69,   46,   47,   85,
 /*   230 */    99,   98,  102,   93,   27,   32,   87,   19,   30,   33,
 /*   240 */     4,   26,  116,  116,    9,   87,   19,   30,   23,   24,
 /*   250 */    35,   92,   43,    9,   41,   34,  137,   23,   24,   35,
 /*   260 */    13,   13,   13,   10,   10,   10,    7,   11,  137,  137,
 /*   270 */   137,    2,    2,   46,   47,  137,   99,   98,  102,   93,
 /*   280 */    27,  137,  137,   56,  137,  105,  137,  117,   70,  137,
 /*   290 */   137,   85,   76,   56,  100,  106,   81,  117,   70,  101,
 /*   300 */   137,   85,   76,   56,  100,  137,  137,  117,   70,   72,
 /*   310 */   137,   85,   76,  137,  100,   87,   19,   30,   70,   73,
 /*   320 */   137,   85,   79,    9,  100,   71,  137,   23,   24,   35,
 /*   330 */    61,  137,  137,  137,  117,   70,  137,  137,   85,   76,
 /*   340 */   137,  100,  137,   75,  137,  137,  137,   65,  137,  137,
 /*   350 */   137,  117,   70,  137,  137,   85,   76,   64,  100,  137,
 /*   360 */   137,  117,   70,  137,  137,   85,   76,  137,  100,   70,
 /*   370 */   137,   49,   85,   82,  137,  100,  137,  137,  137,   58,
 /*   380 */   137,   28,  137,  117,   70,  137,  137,   85,   76,  137,
 /*   390 */   100,   66,  137,  137,  137,  117,   70,  137,  137,   85,
 /*   400 */    76,  137,  100,   63,  137,  137,  137,  117,   70,  137,
 /*   410 */   137,   85,   76,   53,  100,  137,  137,  117,   70,  137,
 /*   420 */   137,   85,   76,  137,  100,   96,  137,  137,  137,  117,
 /*   430 */    70,  137,  137,   85,   76,   74,  100,  137,  137,  117,
 /*   440 */    70,  137,  137,   85,   76,  137,  100,  109,  137,  137,
 /*   450 */   137,  117,   70,  137,  137,   85,   76,  137,  100,   60,
 /*   460 */   137,  137,  137,  117,   70,  137,  137,   85,   76,   39,
 /*   470 */   100,  137,  137,  117,   70,  137,  137,   85,   76,  137,
 /*   480 */   100,   55,  137,  137,  137,  117,   70,  137,  137,   85,
 /*   490 */    76,   54,  100,  137,  137,  117,   70,  137,  137,   85,
 /*   500 */    76,  137,  100,   57,  137,  137,  137,  117,   70,  137,
 /*   510 */   137,   85,   76,   70,  100,  118,   85,   82,  137,  100,
 /*   520 */   137,   50,  137,   86,   70,   28,  137,   85,   76,   62,
 /*   530 */   100,  137,  137,  117,   70,  137,  137,   85,   76,  137,
 /*   540 */   100,   52,  137,  137,  137,  117,   70,  137,  137,   85,
 /*   550 */    76,   59,  100,  137,  137,  117,   70,  137,  137,   85,
 /*   560 */    76,  137,  100,   40,  137,  137,  137,  117,   70,  137,
 /*   570 */   137,   85,   76,   70,  100,  137,   85,   79,   70,  100,
 /*   580 */   103,   85,  104,  137,  100,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,    3,   20,   21,   22,   23,   24,    5,   10,   11,
 /*    10 */    12,   13,   14,   15,   16,   17,   18,   19,   20,   21,
 /*    20 */    22,   23,   24,    2,    3,    7,    8,    9,   30,   52,
 /*    30 */    53,   10,   11,   12,   13,   14,   15,   16,   17,   18,
 /*    40 */    19,   20,   21,   22,   23,   24,   10,   11,   12,   13,
 /*    50 */    14,   15,   16,   17,   18,   19,   20,   21,   22,   23,
 /*    60 */    24,    6,    7,    8,    9,   44,   25,   60,    2,    3,
 /*    70 */    63,   64,   60,   66,    5,   63,   10,   11,   12,   13,
 /*    80 */    14,   15,   16,   17,   18,   19,   20,   21,   22,   23,
 /*    90 */    24,    2,    3,   54,   23,   24,   30,   58,   29,   10,
 /*   100 */    11,   12,   13,   14,   15,   16,   17,   18,   19,   20,
 /*   110 */    21,   22,   23,   24,    3,   16,   25,   60,   53,    6,
 /*   120 */    63,   10,   11,   12,   13,   14,   15,   16,   17,   18,
 /*   130 */    19,   20,   21,   22,   23,   24,   11,   12,   13,   14,
 /*   140 */    15,   16,   17,   18,   19,   20,   21,   22,   23,   24,
 /*   150 */    26,   27,   28,    7,    8,    9,   32,   44,   34,   35,
 /*   160 */    36,   37,   38,   39,   40,    1,   63,   48,   65,   26,
 /*   170 */    27,   28,   69,    9,   31,   32,   33,   34,   70,   42,
 /*   180 */    43,   38,   39,   40,    9,   48,   63,   41,   54,   26,
 /*   190 */    27,   28,   56,   29,    9,   32,   60,   34,   54,   63,
 /*   200 */    37,   38,   39,   40,   29,   61,   42,   43,   54,   45,
 /*   210 */    46,   47,   48,   49,   29,   61,   63,   42,   43,   63,
 /*   220 */    45,   46,   47,   48,   49,   69,   60,   42,   43,   63,
 /*   230 */    45,   46,   47,   48,   49,   53,   26,   27,   28,   53,
 /*   240 */     9,    6,   32,   33,   34,   26,   27,   28,   38,   39,
 /*   250 */    40,   32,   53,   34,   53,   53,   73,   38,   39,   40,
 /*   260 */    17,   18,   19,   20,   21,   22,   23,   24,   73,   73,
 /*   270 */    73,    6,    6,   42,   43,   73,   45,   46,   47,   48,
 /*   280 */    49,   73,   73,   55,   73,   50,   73,   59,   60,   73,
 /*   290 */    73,   63,   64,   55,   66,   30,   30,   59,   60,   71,
 /*   300 */    73,   63,   64,   55,   66,   73,   73,   59,   60,   71,
 /*   310 */    73,   63,   64,   73,   66,   26,   27,   28,   60,   71,
 /*   320 */    73,   63,   64,   34,   66,   67,   73,   38,   39,   40,
 /*   330 */    55,   73,   73,   73,   59,   60,   73,   73,   63,   64,
 /*   340 */    73,   66,   73,   68,   73,   73,   73,   55,   73,   73,
 /*   350 */    73,   59,   60,   73,   73,   63,   64,   55,   66,   73,
 /*   360 */    73,   59,   60,   73,   73,   63,   64,   73,   66,   60,
 /*   370 */    73,   62,   63,   64,   73,   66,   73,   73,   73,   55,
 /*   380 */    73,   72,   73,   59,   60,   73,   73,   63,   64,   73,
 /*   390 */    66,   55,   73,   73,   73,   59,   60,   73,   73,   63,
 /*   400 */    64,   73,   66,   55,   73,   73,   73,   59,   60,   73,
 /*   410 */    73,   63,   64,   55,   66,   73,   73,   59,   60,   73,
 /*   420 */    73,   63,   64,   73,   66,   55,   73,   73,   73,   59,
 /*   430 */    60,   73,   73,   63,   64,   55,   66,   73,   73,   59,
 /*   440 */    60,   73,   73,   63,   64,   73,   66,   55,   73,   73,
 /*   450 */    73,   59,   60,   73,   73,   63,   64,   73,   66,   55,
 /*   460 */    73,   73,   73,   59,   60,   73,   73,   63,   64,   55,
 /*   470 */    66,   73,   73,   59,   60,   73,   73,   63,   64,   73,
 /*   480 */    66,   55,   73,   73,   73,   59,   60,   73,   73,   63,
 /*   490 */    64,   55,   66,   73,   73,   59,   60,   73,   73,   63,
 /*   500 */    64,   73,   66,   55,   73,   73,   73,   59,   60,   73,
 /*   510 */    73,   63,   64,   60,   66,   62,   63,   64,   73,   66,
 /*   520 */    73,   57,   73,   59,   60,   72,   73,   63,   64,   55,
 /*   530 */    66,   73,   73,   59,   60,   73,   73,   63,   64,   73,
 /*   540 */    66,   55,   73,   73,   73,   59,   60,   73,   73,   63,
 /*   550 */    64,   55,   66,   73,   73,   59,   60,   73,   73,   63,
 /*   560 */    64,   73,   66,   55,   73,   73,   73,   59,   60,   73,
 /*   570 */    73,   63,   64,   60,   66,   73,   63,   64,   60,   66,
 /*   580 */    67,   63,   64,   73,   66,
);
    const YY_SHIFT_USE_DFLT = -19;
    const YY_SHIFT_MAX = 79;
    static public $yy_shift_ofst = array(
 /*     0 */   -19,  164,  164,  164,  164,  164,  164,  164,  164,  164,
 /*    10 */   164,  164,  164,  164,  164,  164,  164,  164,  164,  164,
 /*    20 */   164,  164,  164,  175,  175,  185,  231,  231,  231,  231,
 /*    30 */   137,  119,  124,  124,  143,  137,  137,  137,  119,   89,
 /*    40 */    89,  210,  163,  219,  289,   69,  119,  119,  -19,  -19,
 /*    50 */   -19,  -19,   66,   21,   -2,   89,   89,   89,   89,   89,
 /*    60 */    89,   89,  111,   36,  125,  243,  -18,   55,  146,   18,
 /*    70 */    18,  235,  265,  266,   71,  113,   41,   91,   99,    2,
);
    const YY_REDUCE_USE_DFLT = -24;
    const YY_REDUCE_MAX = 51;
    static public $yy_reduce_ofst = array(
 /*     0 */   -23,  248,  228,  238,  275,  292,  302,  392,  404,  414,
 /*    10 */   380,  370,  324,  336,  348,  436,  358,  426,  448,  496,
 /*    20 */   508,  474,  486,  453,  309,  464,  513,  258,    7,  518,
 /*    30 */   136,  103,  154,  144,   39,   12,  166,   57,  156,  182,
 /*    40 */   186,  134,  134,  134,  134,  108,  123,  153,   65,  199,
 /*    50 */   202,  201,
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
        /* 23 */ array(9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 24 */ array(9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 25 */ array(9, 29, 42, 43, 45, 46, 47, 48, 49, ),
        /* 26 */ array(9, 42, 43, 45, 46, 47, 48, 49, ),
        /* 27 */ array(9, 42, 43, 45, 46, 47, 48, 49, ),
        /* 28 */ array(9, 42, 43, 45, 46, 47, 48, 49, ),
        /* 29 */ array(9, 42, 43, 45, 46, 47, 48, 49, ),
        /* 30 */ array(42, 43, 48, ),
        /* 31 */ array(48, ),
        /* 32 */ array(26, 27, 28, 32, 34, 35, 36, 37, 38, 39, 40, ),
        /* 33 */ array(26, 27, 28, 32, 34, 35, 36, 37, 38, 39, 40, ),
        /* 34 */ array(26, 27, 28, 31, 32, 33, 34, 38, 39, 40, ),
        /* 35 */ array(42, 43, 48, ),
        /* 36 */ array(42, 43, 48, ),
        /* 37 */ array(42, 43, 48, ),
        /* 38 */ array(48, ),
        /* 39 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 40 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 41 */ array(26, 27, 28, 32, 33, 34, 38, 39, 40, ),
        /* 42 */ array(26, 27, 28, 32, 34, 37, 38, 39, 40, ),
        /* 43 */ array(26, 27, 28, 32, 34, 38, 39, 40, ),
        /* 44 */ array(26, 27, 28, 34, 38, 39, 40, ),
        /* 45 */ array(5, 29, ),
        /* 46 */ array(48, ),
        /* 47 */ array(48, ),
        /* 48 */ array(),
        /* 49 */ array(),
        /* 50 */ array(),
        /* 51 */ array(),
        /* 52 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 30, ),
        /* 53 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 44, ),
        /* 54 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 30, ),
        /* 55 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 56 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 57 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 58 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 59 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 60 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 61 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 62 */ array(3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 63 */ array(10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 64 */ array(11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 65 */ array(17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 66 */ array(20, 21, 22, 23, 24, ),
        /* 67 */ array(6, 7, 8, 9, ),
        /* 68 */ array(7, 8, 9, 41, ),
        /* 69 */ array(7, 8, 9, ),
        /* 70 */ array(7, 8, 9, ),
        /* 71 */ array(6, 50, ),
        /* 72 */ array(6, 30, ),
        /* 73 */ array(6, 30, ),
        /* 74 */ array(23, 24, ),
        /* 75 */ array(6, 44, ),
        /* 76 */ array(25, ),
        /* 77 */ array(25, ),
        /* 78 */ array(16, ),
        /* 79 */ array(5, ),
        /* 80 */ array(),
        /* 81 */ array(),
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
);
    static public $yy_default = array(
 /*     0 */   121,  181,  181,  181,  181,  181,  181,  181,  181,  181,
 /*    10 */   181,  181,  181,  181,  181,  181,  181,  181,  181,  181,
 /*    20 */   181,  181,  181,  171,  171,  181,  181,  181,  173,  181,
 /*    30 */   181,  181,  181,  181,  181,  181,  181,  181,  181,  121,
 /*    40 */   121,  181,  181,  181,  119,  176,  181,  181,  121,  121,
 /*    50 */   121,  121,  181,  181,  181,  137,  180,  165,  166,  123,
 /*    60 */   143,  167,  144,  145,  146,  147,  149,  127,  181,  128,
 /*    70 */   158,  181,  181,  181,  148,  181,  155,  154,  181,  181,
 /*    80 */   141,  172,  175,  142,  174,  138,  125,  122,  126,  120,
 /*    90 */   130,  134,  136,  161,  139,  140,  150,  169,  159,  157,
 /*   100 */   156,  179,  160,  164,  177,  162,  178,  170,  124,  151,
 /*   110 */   163,  132,  133,  131,  152,  168,  129,  153,  135,
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
    const YYNSTATE = 119;
    const YYNRULE = 62;
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
  'term_simple',   'filters',       'json',          'json_obj',    
  'json_arr',      'filter',        'arguments',     'args',        
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
 /*  42 */ "alpha ::= T_ALPHA",
 /*  43 */ "json ::= T_CURLY_OPEN json_obj T_CURLY_CLOSE",
 /*  44 */ "json ::= T_BRACKETS_OPEN json_arr T_BRACKETS_CLOSE",
 /*  45 */ "json_obj ::= json_obj T_COMMA json_obj",
 /*  46 */ "json_obj ::= term_simple T_COLON expr",
 /*  47 */ "json_arr ::= json_arr T_COMMA expr",
 /*  48 */ "json_arr ::= expr",
 /*  49 */ "filters ::= filters T_FILTER_PIPE filter",
 /*  50 */ "filters ::= filter",
 /*  51 */ "filter ::= alpha arguments",
 /*  52 */ "arguments_list ::=",
 /*  53 */ "arguments_list ::= T_LPARENT args T_RPARENT",
 /*  54 */ "arguments_list ::= term_list",
 /*  55 */ "term_list ::= term_list term_simple",
 /*  56 */ "term_list ::= term_simple",
 /*  57 */ "arguments ::=",
 /*  58 */ "arguments ::= T_COLON term_simple",
 /*  59 */ "arguments ::= T_LPARENT args T_RPARENT",
 /*  60 */ "args ::= args T_COMMA args",
 /*  61 */ "args ::= expr",
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
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 3 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 2 ),
  array( 'lhs' => 62, 'rhs' => 0 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 62, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 2 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 0 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
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
        15 => 2,
        57 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        34 => 6,
        36 => 6,
        39 => 6,
        42 => 6,
        54 => 6,
        7 => 7,
        10 => 7,
        14 => 7,
        44 => 7,
        53 => 7,
        59 => 7,
        8 => 8,
        48 => 8,
        50 => 8,
        56 => 8,
        58 => 8,
        61 => 8,
        9 => 9,
        12 => 12,
        13 => 12,
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
        43 => 43,
        45 => 45,
        46 => 46,
        47 => 47,
        49 => 47,
        51 => 51,
        55 => 55,
        60 => 60,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 83 "lib/Haanga2/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1253 "lib/Haanga2/Compiler/Parser.php"
#line 85 "lib/Haanga2/Compiler/Parser.y"
    function yy_r1(){ $this->yystack[$this->yyidx + -1]->minor[] = $this->yystack[$this->yyidx + 0]->minor; $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1256 "lib/Haanga2/Compiler/Parser.php"
#line 86 "lib/Haanga2/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1259 "lib/Haanga2/Compiler/Parser.php"
#line 88 "lib/Haanga2/Compiler/Parser.y"
    function yy_r3(){ $this->_retvalue = new DoPrint(new Term\String($this->yystack[$this->yyidx + 0]->minor));     }
#line 1262 "lib/Haanga2/Compiler/Parser.php"
#line 90 "lib/Haanga2/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = new DoPrint($this->yystack[$this->yyidx + 0]->minor);     }
#line 1265 "lib/Haanga2/Compiler/Parser.php"
#line 93 "lib/Haanga2/Compiler/Parser.y"
    function yy_r5(){ $this->_retvalue = new Term\OpFor($this->yystack[$this->yyidx + -4]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1268 "lib/Haanga2/Compiler/Parser.php"
#line 94 "lib/Haanga2/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1271 "lib/Haanga2/Compiler/Parser.php"
#line 95 "lib/Haanga2/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1274 "lib/Haanga2/Compiler/Parser.php"
#line 96 "lib/Haanga2/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1277 "lib/Haanga2/Compiler/Parser.php"
#line 97 "lib/Haanga2/Compiler/Parser.y"
    function yy_r9(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -2]->minor);     }
#line 1280 "lib/Haanga2/Compiler/Parser.php"
#line 103 "lib/Haanga2/Compiler/Parser.y"
    function yy_r12(){ $this->_retvalue = new DoIf($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1283 "lib/Haanga2/Compiler/Parser.php"
#line 110 "lib/Haanga2/Compiler/Parser.y"
    function yy_r16(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1286 "lib/Haanga2/Compiler/Parser.php"
#line 111 "lib/Haanga2/Compiler/Parser.y"
    function yy_r17(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1289 "lib/Haanga2/Compiler/Parser.php"
#line 115 "lib/Haanga2/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = new DefVariable($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1292 "lib/Haanga2/Compiler/Parser.php"
#line 119 "lib/Haanga2/Compiler/Parser.y"
    function yy_r19(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor);     }
#line 1295 "lib/Haanga2/Compiler/Parser.php"
#line 120 "lib/Haanga2/Compiler/Parser.y"
    function yy_r20(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, 'object');     }
#line 1298 "lib/Haanga2/Compiler/Parser.php"
#line 121 "lib/Haanga2/Compiler/Parser.y"
    function yy_r21(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, 'array');     }
#line 1301 "lib/Haanga2/Compiler/Parser.php"
#line 122 "lib/Haanga2/Compiler/Parser.y"
    function yy_r22(){ $this->yystack[$this->yyidx + -2]->minor->addPart($this->yystack[$this->yyidx + 0]->minor, 'object'); $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor;     }
#line 1304 "lib/Haanga2/Compiler/Parser.php"
#line 123 "lib/Haanga2/Compiler/Parser.y"
    function yy_r23(){ $this->yystack[$this->yyidx + -3]->minor->addPart($this->yystack[$this->yyidx + -1]->minor, 'array'); $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor ;     }
#line 1307 "lib/Haanga2/Compiler/Parser.php"
#line 127 "lib/Haanga2/Compiler/Parser.y"
    function yy_r24(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + 0]->minor, 'not');     }
#line 1310 "lib/Haanga2/Compiler/Parser.php"
#line 128 "lib/Haanga2/Compiler/Parser.y"
    function yy_r25(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1313 "lib/Haanga2/Compiler/Parser.php"
#line 131 "lib/Haanga2/Compiler/Parser.y"
    function yy_r28(){ $this->_retvalue = new Expr\In($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1316 "lib/Haanga2/Compiler/Parser.php"
#line 135 "lib/Haanga2/Compiler/Parser.y"
    function yy_r32(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @X, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1319 "lib/Haanga2/Compiler/Parser.php"
#line 136 "lib/Haanga2/Compiler/Parser.y"
    function yy_r33(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -1]->minor);     }
#line 1322 "lib/Haanga2/Compiler/Parser.php"
#line 141 "lib/Haanga2/Compiler/Parser.y"
    function yy_r35(){ $this->_retvalue = new Term\Filter($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1325 "lib/Haanga2/Compiler/Parser.php"
#line 143 "lib/Haanga2/Compiler/Parser.y"
    function yy_r37(){ $this->_retvalue = new Term\Json($this->yystack[$this->yyidx + 0]->minor);     }
#line 1328 "lib/Haanga2/Compiler/Parser.php"
#line 144 "lib/Haanga2/Compiler/Parser.y"
    function yy_r38(){ $this->_retvalue = new Term\Boolean($this->yystack[$this->yyidx + 0]->minor);     }
#line 1331 "lib/Haanga2/Compiler/Parser.php"
#line 146 "lib/Haanga2/Compiler/Parser.y"
    function yy_r40(){ $this->_retvalue = new Term\Number($this->yystack[$this->yyidx + 0]->minor);     }
#line 1334 "lib/Haanga2/Compiler/Parser.php"
#line 147 "lib/Haanga2/Compiler/Parser.y"
    function yy_r41(){ $this->_retvalue = new Term\String($this->yystack[$this->yyidx + 0]->minor) ;     }
#line 1337 "lib/Haanga2/Compiler/Parser.php"
#line 153 "lib/Haanga2/Compiler/Parser.y"
    function yy_r43(){ $this->_retvalue  = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1340 "lib/Haanga2/Compiler/Parser.php"
#line 156 "lib/Haanga2/Compiler/Parser.y"
    function yy_r45(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->yystack[$this->yyidx + -2]->minor[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1343 "lib/Haanga2/Compiler/Parser.php"
#line 157 "lib/Haanga2/Compiler/Parser.y"
    function yy_r46(){ $this->_retvalue = array('key' => $this->yystack[$this->yyidx + -2]->minor, 'value' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1346 "lib/Haanga2/Compiler/Parser.php"
#line 159 "lib/Haanga2/Compiler/Parser.y"
    function yy_r47(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1349 "lib/Haanga2/Compiler/Parser.php"
#line 166 "lib/Haanga2/Compiler/Parser.y"
    function yy_r51(){ $this->_retvalue = new Filter($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1352 "lib/Haanga2/Compiler/Parser.php"
#line 173 "lib/Haanga2/Compiler/Parser.y"
    function yy_r55(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1355 "lib/Haanga2/Compiler/Parser.php"
#line 180 "lib/Haanga2/Compiler/Parser.y"
    function yy_r60(){ $this->_retvalue = array_merge($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1358 "lib/Haanga2/Compiler/Parser.php"

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
#line 75 "lib/Haanga2/Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. ')');
#line 1478 "lib/Haanga2/Compiler/Parser.php"
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
#line 58 "lib/Haanga2/Compiler/Parser.y"

#line 1499 "lib/Haanga2/Compiler/Parser.php"
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
