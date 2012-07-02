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
#line 136 "lib/Haanga2/Compiler/Parser.php"

// declare_class is output here
#line 39 "lib/Haanga2/Compiler/Parser.y"
 class Haanga2_Compiler_Parser #line 141 "lib/Haanga2/Compiler/Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 40 "lib/Haanga2/Compiler/Parser.y"

    protected $lex;
    protected $file;

    function __construct($lex, $file='')
    {
        $this->lex  = $lex;
        $this->file = $file;
    }

    function Error($text)
    {
        throw new Haanga_Compiler_Exception($text.' in '.$this->file.':'.$this->lex->getLine());
    }

#line 162 "lib/Haanga2/Compiler/Parser.php"

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
    const T_FOR                          = 27;
    const T_LPARENT                      = 28;
    const T_RPARENT                      = 29;
    const T_EMPTY                        = 30;
    const T_END                          = 31;
    const T_ENDFOR                       = 32;
    const T_IF                           = 33;
    const T_ELIF                         = 34;
    const T_ELSE                         = 35;
    const T_ENDIF                        = 36;
    const T_TAG                          = 37;
    const T_TAG_BLOCK                    = 38;
    const T_SET                          = 39;
    const T_DOLLAR                       = 40;
    const T_AT                           = 41;
    const T_BRACKETS_CLOSE               = 42;
    const T_NUMBER                       = 43;
    const T_STRING                       = 44;
    const T_ALPHA                        = 45;
    const YY_NO_ACTION = 156;
    const YY_ACCEPT_ACTION = 155;
    const YY_ERROR_ACTION = 154;

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
    const YY_SZ_ACTTAB = 409;
static public $yy_action = array(
 /*     0 */     9,   13,    5,    5,    5,    4,   18,   20,    8,    8,
 /*    10 */     8,    8,    8,    8,    7,   16,   16,   16,    5,    5,
 /*    20 */     5,    4,   18,    9,   13,   40,   41,   94,   84,   85,
 /*    30 */    93,    8,    8,    8,    8,    8,    8,    7,   16,   16,
 /*    40 */    16,    5,    5,    5,    4,   18,    8,    8,    8,    8,
 /*    50 */     8,    8,    7,   16,   16,   16,    5,    5,    5,    4,
 /*    60 */    18,   82,   39,   83,   66,   96,    9,   13,   31,   31,
 /*    70 */    11,    2,   14,   25,    8,    8,    8,    8,    8,    8,
 /*    80 */     7,   16,   16,   16,    5,    5,    5,    4,   18,    9,
 /*    90 */    13,   40,   41,   75,   98,   36,   93,    8,    8,    8,
 /*   100 */     8,    8,    8,    7,   16,   16,   16,    5,    5,    5,
 /*   110 */     4,   18,   13,   30,   31,   31,   11,  155,   38,    8,
 /*   120 */     8,    8,    8,    8,    8,    7,   16,   16,   16,    5,
 /*   130 */     5,    5,    4,   18,    8,    8,    8,    8,    8,    7,
 /*   140 */    16,   16,   16,    5,    5,    5,    4,   18,   74,   24,
 /*   150 */    31,   31,   11,   73,   32,   15,   12,   42,   73,   21,
 /*   160 */    19,   29,   74,   24,    4,   18,   43,   78,   78,   15,
 /*   170 */     6,   74,   24,   21,   19,   29,   81,   81,   15,   76,
 /*   180 */    93,   86,   21,   19,   29,   16,   16,   16,    5,    5,
 /*   190 */     5,    4,   18,   74,   24,   76,   39,   10,   70,   87,
 /*   200 */    15,  120,   68,   70,   21,   19,   29,   99,   92,   40,
 /*   210 */    41,  100,   84,   85,   93,   74,   24,    2,    3,   37,
 /*   220 */    72,   35,   15,   28,   65,   27,   21,   19,   29,   58,
 /*   230 */    40,   41,  100,   84,   85,   93,   88,   50,   59,   26,
 /*   240 */    95,  100,   64,   74,   24,  120,   61,   88,   50,   59,
 /*   250 */    15,  120,  100,   64,   21,   19,   29,   62,   88,   50,
 /*   260 */    59,  120,   17,  100,   64,   44,  120,   77,   97,   59,
 /*   270 */   120,  120,  100,   64,   40,   41,  120,   84,   85,   93,
 /*   280 */    88,   46,   59,   22,   57,  100,   64,  100,   88,   47,
 /*   290 */    59,  120,   76,  100,   64,   88,   33,   59,  120,   69,
 /*   300 */   100,   64,   88,   52,   59,  120,    1,  100,   64,   88,
 /*   310 */    54,   59,  120,  120,  100,   64,   88,   63,   59,  120,
 /*   320 */   120,  100,   64,   59,  120,   71,  100,   67,   88,   51,
 /*   330 */    59,  120,   23,  100,   64,   88,   55,   59,  120,  120,
 /*   340 */   100,   64,   88,   53,   59,  120,  120,  100,   64,   88,
 /*   350 */    49,   59,  120,  120,  100,   64,   88,   90,   59,  120,
 /*   360 */   120,  100,   64,   88,   48,   59,  120,  120,  100,   64,
 /*   370 */    88,   34,   59,  120,  120,  100,   64,   88,   89,   59,
 /*   380 */   120,  120,  100,   64,   88,   56,   59,  120,  120,  100,
 /*   390 */    64,   59,  120,   45,  100,   67,   60,  120,   59,  100,
 /*   400 */    23,  100,   80,   59,  120,   76,  100,   91,   79,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,    3,   20,   21,   22,   23,   24,   16,   10,   11,
 /*    10 */    12,   13,   14,   15,   16,   17,   18,   19,   20,   21,
 /*    20 */    22,   23,   24,    2,    3,   40,   41,   29,   43,   44,
 /*    30 */    45,   10,   11,   12,   13,   14,   15,   16,   17,   18,
 /*    40 */    19,   20,   21,   22,   23,   24,   10,   11,   12,   13,
 /*    50 */    14,   15,   16,   17,   18,   19,   20,   21,   22,   23,
 /*    60 */    24,   58,   58,   42,   60,   61,    2,    3,    7,    8,
 /*    70 */     9,    6,   11,   25,   10,   11,   12,   13,   14,   15,
 /*    80 */    16,   17,   18,   19,   20,   21,   22,   23,   24,    2,
 /*    90 */     3,   40,   41,   29,   29,   48,   45,   10,   11,   12,
 /*   100 */    13,   14,   15,   16,   17,   18,   19,   20,   21,   22,
 /*   110 */    23,   24,    3,    6,    7,    8,    9,   47,   48,   10,
 /*   120 */    11,   12,   13,   14,   15,   16,   17,   18,   19,   20,
 /*   130 */    21,   22,   23,   24,   11,   12,   13,   14,   15,   16,
 /*   140 */    17,   18,   19,   20,   21,   22,   23,   24,   26,   27,
 /*   150 */     7,    8,    9,   31,   25,   33,   34,   35,   36,   37,
 /*   160 */    38,   39,   26,   27,   23,   24,   30,   31,   32,   33,
 /*   170 */     1,   26,   27,   37,   38,   39,   31,   32,   33,   49,
 /*   180 */    45,   62,   37,   38,   39,   17,   18,   19,   20,   21,
 /*   190 */    22,   23,   24,   26,   27,   49,   58,   28,   31,   61,
 /*   200 */    33,   65,   56,   36,   37,   38,   39,   58,   55,   40,
 /*   210 */    41,   58,   43,   44,   45,   26,   27,    6,   28,   48,
 /*   220 */    31,   48,   33,   48,   50,   48,   37,   38,   39,   55,
 /*   230 */    40,   41,   58,   43,   44,   45,   53,   54,   55,   48,
 /*   240 */    29,   58,   59,   26,   27,   65,   63,   53,   54,   55,
 /*   250 */    33,   65,   58,   59,   37,   38,   39,   63,   53,   54,
 /*   260 */    55,   65,   28,   58,   59,   51,   65,   53,   63,   55,
 /*   270 */    65,   65,   58,   59,   40,   41,   65,   43,   44,   45,
 /*   280 */    53,   54,   55,    5,   55,   58,   59,   58,   53,   54,
 /*   290 */    55,   65,   49,   58,   59,   53,   54,   55,   65,   56,
 /*   300 */    58,   59,   53,   54,   55,   65,   28,   58,   59,   53,
 /*   310 */    54,   55,   65,   65,   58,   59,   53,   54,   55,   65,
 /*   320 */    65,   58,   59,   55,   65,   57,   58,   59,   53,   54,
 /*   330 */    55,   65,   64,   58,   59,   53,   54,   55,   65,   65,
 /*   340 */    58,   59,   53,   54,   55,   65,   65,   58,   59,   53,
 /*   350 */    54,   55,   65,   65,   58,   59,   53,   54,   55,   65,
 /*   360 */    65,   58,   59,   53,   54,   55,   65,   65,   58,   59,
 /*   370 */    53,   54,   55,   65,   65,   58,   59,   53,   54,   55,
 /*   380 */    65,   65,   58,   59,   53,   54,   55,   65,   65,   58,
 /*   390 */    59,   55,   65,   57,   58,   59,   55,   65,   55,   58,
 /*   400 */    64,   58,   59,   55,   65,   49,   58,   59,   52,
);
    const YY_SHIFT_USE_DFLT = -19;
    const YY_SHIFT_MAX = 66;
    static public $yy_shift_ofst = array(
 /*     0 */   -19,  169,  169,  169,  169,  169,  169,  169,  169,  169,
 /*    10 */   169,  169,  169,  169,  169,  169,  169,  169,  169,  190,
 /*    20 */   234,  190,  -15,  -15,   51,  135,  122,  122,  136,   51,
 /*    30 */    51,   51,  135,   87,   87,  145,  167,  189,  217,  278,
 /*    40 */   135,  135,  -19,  -19,  -19,  -19,   -2,   21,   64,   87,
 /*    50 */    87,   87,  109,   36,  123,  168,  -18,   61,  107,  143,
 /*    60 */   143,   65,  211,  141,   48,   -9,  129,
);
    const YY_REDUCE_USE_DFLT = -1;
    const YY_REDUCE_MAX = 45;
    static public $yy_reduce_ofst = array(
 /*     0 */    70,  183,  205,  194,  324,  263,  275,  282,  256,  249,
 /*    10 */   227,  235,  242,  289,  296,  317,  331,  310,  303,  336,
 /*    20 */   214,  268,  348,  343,  174,    4,  146,  243,  356,  229,
 /*    30 */   341,  153,  138,  177,  191,  130,  130,  130,  130,  119,
 /*    40 */     3,  149,   47,  173,  175,  171,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 2 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 3 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 4 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 5 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 6 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 7 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 8 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 9 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 10 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 11 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 12 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 13 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 14 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 15 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 16 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 17 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 18 */ array(1, 28, 40, 41, 43, 44, 45, ),
        /* 19 */ array(28, 40, 41, 43, 44, 45, ),
        /* 20 */ array(28, 40, 41, 43, 44, 45, ),
        /* 21 */ array(28, 40, 41, 43, 44, 45, ),
        /* 22 */ array(40, 41, 43, 44, 45, ),
        /* 23 */ array(40, 41, 43, 44, 45, ),
        /* 24 */ array(40, 41, 45, ),
        /* 25 */ array(45, ),
        /* 26 */ array(26, 27, 31, 33, 34, 35, 36, 37, 38, 39, ),
        /* 27 */ array(26, 27, 31, 33, 34, 35, 36, 37, 38, 39, ),
        /* 28 */ array(26, 27, 30, 31, 32, 33, 37, 38, 39, ),
        /* 29 */ array(40, 41, 45, ),
        /* 30 */ array(40, 41, 45, ),
        /* 31 */ array(40, 41, 45, ),
        /* 32 */ array(45, ),
        /* 33 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 34 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 35 */ array(26, 27, 31, 32, 33, 37, 38, 39, ),
        /* 36 */ array(26, 27, 31, 33, 36, 37, 38, 39, ),
        /* 37 */ array(26, 27, 31, 33, 37, 38, 39, ),
        /* 38 */ array(26, 27, 33, 37, 38, 39, ),
        /* 39 */ array(5, 28, ),
        /* 40 */ array(45, ),
        /* 41 */ array(45, ),
        /* 42 */ array(),
        /* 43 */ array(),
        /* 44 */ array(),
        /* 45 */ array(),
        /* 46 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 29, ),
        /* 47 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 42, ),
        /* 48 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 29, ),
        /* 49 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 50 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 51 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 52 */ array(3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 53 */ array(10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 54 */ array(11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 55 */ array(17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 56 */ array(20, 21, 22, 23, 24, ),
        /* 57 */ array(7, 8, 9, 11, ),
        /* 58 */ array(6, 7, 8, 9, ),
        /* 59 */ array(7, 8, 9, ),
        /* 60 */ array(7, 8, 9, ),
        /* 61 */ array(6, 29, ),
        /* 62 */ array(6, 29, ),
        /* 63 */ array(23, 24, ),
        /* 64 */ array(25, ),
        /* 65 */ array(16, ),
        /* 66 */ array(25, ),
        /* 67 */ array(),
        /* 68 */ array(),
        /* 69 */ array(),
        /* 70 */ array(),
        /* 71 */ array(),
        /* 72 */ array(),
        /* 73 */ array(),
        /* 74 */ array(),
        /* 75 */ array(),
        /* 76 */ array(),
        /* 77 */ array(),
        /* 78 */ array(),
        /* 79 */ array(),
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
);
    static public $yy_default = array(
 /*     0 */   103,  154,  154,  154,  154,  154,  154,  154,  154,  154,
 /*    10 */   154,  154,  154,  154,  154,  154,  154,  154,  154,  144,
 /*    20 */   154,  144,  154,  146,  154,  154,  154,  154,  154,  154,
 /*    30 */   154,  154,  154,  103,  103,  154,  154,  154,  101,  149,
 /*    40 */   154,  154,  103,  103,  103,  103,  154,  154,  154,  118,
 /*    50 */   153,  124,  125,  126,  127,  128,  130,  154,  108,  137,
 /*    60 */   109,  154,  154,  129,  136,  154,  135,  148,  112,  113,
 /*    70 */   114,  116,  117,  115,  104,  107,  102,  106,  111,  105,
 /*    80 */   147,  110,  120,  123,  138,  139,  143,  141,  134,  132,
 /*    90 */   131,  150,  122,  140,  133,  145,  142,  152,  151,  121,
 /*   100 */   119,
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
    const YYNOCODE = 66;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 101;
    const YYNRULE = 53;
    const YYERRORSYMBOL = 46;
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
  'T_BITWISE',     'T_FILTER_PIPE',  'T_HTML',        'T_FOR',       
  'T_LPARENT',     'T_RPARENT',     'T_EMPTY',       'T_END',       
  'T_ENDFOR',      'T_IF',          'T_ELIF',        'T_ELSE',      
  'T_ENDIF',       'T_TAG',         'T_TAG_BLOCK',   'T_SET',       
  'T_DOLLAR',      'T_AT',          'T_BRACKETS_CLOSE',  'T_NUMBER',    
  'T_STRING',      'T_ALPHA',       'error',         'start',       
  'body',          'code',          'for_dest',      'for_source',  
  'for_end',       'term',          'expr',          'variable',    
  'if_end',        'arguments_list',  'alpha',         'term_simple', 
  'filters',       'filter',        'arguments',     'args',        
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
 /*   4 */ "code ::= T_FOR for_dest T_IN for_source body for_end",
 /*   5 */ "for_source ::= term",
 /*   6 */ "for_source ::= T_LPARENT expr T_RPARENT",
 /*   7 */ "for_dest ::= variable",
 /*   8 */ "for_dest ::= variable T_COMMA variable",
 /*   9 */ "for_end ::= T_EMPTY body T_END|T_ENDFOR",
 /*  10 */ "for_end ::= T_END|T_ENDFOR",
 /*  11 */ "code ::= T_IF expr body if_end",
 /*  12 */ "if_end ::= T_ELIF expr body if_end",
 /*  13 */ "if_end ::= T_ELSE body T_END|T_ENDIF",
 /*  14 */ "if_end ::= T_END|T_ENDIF",
 /*  15 */ "code ::= T_TAG arguments_list",
 /*  16 */ "code ::= T_TAG_BLOCK arguments_list body T_END",
 /*  17 */ "code ::= T_SET variable T_EQ expr",
 /*  18 */ "variable ::= alpha",
 /*  19 */ "variable ::= T_DOLLAR alpha",
 /*  20 */ "variable ::= T_AT alpha",
 /*  21 */ "variable ::= variable T_DOT|T_OBJ variable",
 /*  22 */ "variable ::= variable T_BRACKETS_OPEN expr T_BRACKETS_CLOSE",
 /*  23 */ "expr ::= T_NOT expr",
 /*  24 */ "expr ::= expr T_AND expr",
 /*  25 */ "expr ::= expr T_OR expr",
 /*  26 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE expr",
 /*  27 */ "expr ::= expr T_IN expr",
 /*  28 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  29 */ "expr ::= expr T_PLUS|T_MINUS|T_CONCAT expr",
 /*  30 */ "expr ::= expr T_BITWISE expr",
 /*  31 */ "expr ::= expr T_PIPE expr",
 /*  32 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  33 */ "expr ::= term",
 /*  34 */ "term ::= term_simple T_FILTER_PIPE filters",
 /*  35 */ "term ::= term_simple",
 /*  36 */ "term_simple ::= variable",
 /*  37 */ "term_simple ::= T_NUMBER",
 /*  38 */ "term_simple ::= T_STRING",
 /*  39 */ "alpha ::= T_ALPHA",
 /*  40 */ "filters ::= filters T_FILTER_PIPE filter",
 /*  41 */ "filters ::= filter",
 /*  42 */ "filter ::= alpha arguments",
 /*  43 */ "arguments_list ::=",
 /*  44 */ "arguments_list ::= T_LPARENT args T_RPARENT",
 /*  45 */ "arguments_list ::= term_list",
 /*  46 */ "term_list ::= term_list term_simple",
 /*  47 */ "term_list ::= term_simple",
 /*  48 */ "arguments ::=",
 /*  49 */ "arguments ::= T_COLON term_simple",
 /*  50 */ "arguments ::= T_LPARENT args T_RPARENT",
 /*  51 */ "args ::= args T_COMMA args",
 /*  52 */ "args ::= expr",
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
  array( 'lhs' => 47, 'rhs' => 1 ),
  array( 'lhs' => 48, 'rhs' => 2 ),
  array( 'lhs' => 48, 'rhs' => 0 ),
  array( 'lhs' => 49, 'rhs' => 1 ),
  array( 'lhs' => 49, 'rhs' => 6 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 3 ),
  array( 'lhs' => 50, 'rhs' => 1 ),
  array( 'lhs' => 50, 'rhs' => 3 ),
  array( 'lhs' => 52, 'rhs' => 3 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 49, 'rhs' => 4 ),
  array( 'lhs' => 56, 'rhs' => 4 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 49, 'rhs' => 2 ),
  array( 'lhs' => 49, 'rhs' => 4 ),
  array( 'lhs' => 49, 'rhs' => 4 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 4 ),
  array( 'lhs' => 54, 'rhs' => 2 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 59, 'rhs' => 1 ),
  array( 'lhs' => 59, 'rhs' => 1 ),
  array( 'lhs' => 59, 'rhs' => 1 ),
  array( 'lhs' => 58, 'rhs' => 1 ),
  array( 'lhs' => 60, 'rhs' => 3 ),
  array( 'lhs' => 60, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 2 ),
  array( 'lhs' => 57, 'rhs' => 0 ),
  array( 'lhs' => 57, 'rhs' => 3 ),
  array( 'lhs' => 57, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 2 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 62, 'rhs' => 0 ),
  array( 'lhs' => 62, 'rhs' => 2 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
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
        48 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        33 => 5,
        35 => 5,
        36 => 5,
        39 => 5,
        45 => 5,
        6 => 6,
        9 => 6,
        13 => 6,
        44 => 6,
        50 => 6,
        7 => 7,
        41 => 7,
        47 => 7,
        49 => 7,
        52 => 7,
        8 => 8,
        11 => 11,
        12 => 11,
        15 => 15,
        16 => 16,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 24,
        26 => 24,
        28 => 24,
        29 => 24,
        30 => 24,
        27 => 27,
        31 => 31,
        32 => 32,
        34 => 34,
        37 => 37,
        38 => 38,
        40 => 40,
        42 => 42,
        46 => 46,
        51 => 51,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 82 "lib/Haanga2/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1160 "lib/Haanga2/Compiler/Parser.php"
#line 84 "lib/Haanga2/Compiler/Parser.y"
    function yy_r1(){ $this->yystack[$this->yyidx + -1]->minor[] = $this->yystack[$this->yyidx + 0]->minor; $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1163 "lib/Haanga2/Compiler/Parser.php"
#line 85 "lib/Haanga2/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1166 "lib/Haanga2/Compiler/Parser.php"
#line 87 "lib/Haanga2/Compiler/Parser.y"
    function yy_r3(){ $this->_retvalue = new HTML($this->yystack[$this->yyidx + 0]->minor);     }
#line 1169 "lib/Haanga2/Compiler/Parser.php"
#line 90 "lib/Haanga2/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = new Term\OpFor($this->yystack[$this->yyidx + -4]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1172 "lib/Haanga2/Compiler/Parser.php"
#line 91 "lib/Haanga2/Compiler/Parser.y"
    function yy_r5(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1175 "lib/Haanga2/Compiler/Parser.php"
#line 92 "lib/Haanga2/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1178 "lib/Haanga2/Compiler/Parser.php"
#line 93 "lib/Haanga2/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1181 "lib/Haanga2/Compiler/Parser.php"
#line 94 "lib/Haanga2/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -2]->minor);     }
#line 1184 "lib/Haanga2/Compiler/Parser.php"
#line 100 "lib/Haanga2/Compiler/Parser.y"
    function yy_r11(){ $this->_retvalue = new Code\opIf($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1187 "lib/Haanga2/Compiler/Parser.php"
#line 107 "lib/Haanga2/Compiler/Parser.y"
    function yy_r15(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1190 "lib/Haanga2/Compiler/Parser.php"
#line 108 "lib/Haanga2/Compiler/Parser.y"
    function yy_r16(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1193 "lib/Haanga2/Compiler/Parser.php"
#line 112 "lib/Haanga2/Compiler/Parser.y"
    function yy_r17(){ $this->_retvalue = new DefVariable($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1196 "lib/Haanga2/Compiler/Parser.php"
#line 116 "lib/Haanga2/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor);     }
#line 1199 "lib/Haanga2/Compiler/Parser.php"
#line 117 "lib/Haanga2/Compiler/Parser.y"
    function yy_r19(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, 'object');     }
#line 1202 "lib/Haanga2/Compiler/Parser.php"
#line 118 "lib/Haanga2/Compiler/Parser.y"
    function yy_r20(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, 'array');     }
#line 1205 "lib/Haanga2/Compiler/Parser.php"
#line 119 "lib/Haanga2/Compiler/Parser.y"
    function yy_r21(){ $this->yystack[$this->yyidx + -2]->minor->addPart($this->yystack[$this->yyidx + 0]->minor, 'object'); $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor;     }
#line 1208 "lib/Haanga2/Compiler/Parser.php"
#line 120 "lib/Haanga2/Compiler/Parser.y"
    function yy_r22(){ $this->yystack[$this->yyidx + -3]->minor->addPart($this->yystack[$this->yyidx + -1]->minor, 'array'); $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor ;     }
#line 1211 "lib/Haanga2/Compiler/Parser.php"
#line 124 "lib/Haanga2/Compiler/Parser.y"
    function yy_r23(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + 0]->minor, 'not');     }
#line 1214 "lib/Haanga2/Compiler/Parser.php"
#line 125 "lib/Haanga2/Compiler/Parser.y"
    function yy_r24(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1217 "lib/Haanga2/Compiler/Parser.php"
#line 128 "lib/Haanga2/Compiler/Parser.y"
    function yy_r27(){ $this->_retvalue = new Expr\In($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1220 "lib/Haanga2/Compiler/Parser.php"
#line 132 "lib/Haanga2/Compiler/Parser.y"
    function yy_r31(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @X, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1223 "lib/Haanga2/Compiler/Parser.php"
#line 133 "lib/Haanga2/Compiler/Parser.y"
    function yy_r32(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -1]->minor);     }
#line 1226 "lib/Haanga2/Compiler/Parser.php"
#line 138 "lib/Haanga2/Compiler/Parser.y"
    function yy_r34(){ $this->_retvalue = new Term\Filter($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1229 "lib/Haanga2/Compiler/Parser.php"
#line 141 "lib/Haanga2/Compiler/Parser.y"
    function yy_r37(){ $this->_retvalue = new Term\Number($this->yystack[$this->yyidx + 0]->minor);     }
#line 1232 "lib/Haanga2/Compiler/Parser.php"
#line 142 "lib/Haanga2/Compiler/Parser.y"
    function yy_r38(){ $this->_retvalue = new Term\String($this->yystack[$this->yyidx + 0]->minor) ;     }
#line 1235 "lib/Haanga2/Compiler/Parser.php"
#line 148 "lib/Haanga2/Compiler/Parser.y"
    function yy_r40(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1238 "lib/Haanga2/Compiler/Parser.php"
#line 150 "lib/Haanga2/Compiler/Parser.y"
    function yy_r42(){ $this->_retvalue = new Filter($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1241 "lib/Haanga2/Compiler/Parser.php"
#line 157 "lib/Haanga2/Compiler/Parser.y"
    function yy_r46(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1244 "lib/Haanga2/Compiler/Parser.php"
#line 164 "lib/Haanga2/Compiler/Parser.y"
    function yy_r51(){ $this->_retvalue = array_merge($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1247 "lib/Haanga2/Compiler/Parser.php"

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
#line 74 "lib/Haanga2/Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. ')');
#line 1367 "lib/Haanga2/Compiler/Parser.php"
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
#line 57 "lib/Haanga2/Compiler/Parser.y"

#line 1388 "lib/Haanga2/Compiler/Parser.php"
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
