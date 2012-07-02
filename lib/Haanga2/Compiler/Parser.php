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
  | Copyright (c) 2010 César Rodas and Menéame Comunicacions S.L.                   |
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
    const T_FOR                          = 26;
    const T_LPARENT                      = 27;
    const T_RPARENT                      = 28;
    const T_EMPTY                        = 29;
    const T_END                          = 30;
    const T_ENDFOR                       = 31;
    const T_IF                           = 32;
    const T_ELIF                         = 33;
    const T_ELSE                         = 34;
    const T_ENDIF                        = 35;
    const T_TAG                          = 36;
    const T_TAG_BLOCK                    = 37;
    const T_SET                          = 38;
    const T_DOLLAR                       = 39;
    const T_AT                           = 40;
    const T_BRACKETS_CLOSE               = 41;
    const T_NUMBER                       = 42;
    const T_STRING                       = 43;
    const T_ALPHA                        = 44;
    const YY_NO_ACTION = 154;
    const YY_ACCEPT_ACTION = 153;
    const YY_ERROR_ACTION = 152;

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
    const YY_SZ_ACTTAB = 430;
static public $yy_action = array(
 /*     0 */     7,    6,   40,   41,   20,   94,   89,   67,    4,    4,
 /*    10 */     4,    4,    4,    4,    5,   15,   15,   15,    8,    8,
 /*    20 */     8,   10,   16,    7,    6,   60,   79,   59,   81,   90,
 /*    30 */    81,    4,    4,    4,    4,    4,    4,    5,   15,   15,
 /*    40 */    15,    8,    8,    8,   10,   16,    7,    6,   32,   92,
 /*    50 */    31,   31,   14,   28,    4,    4,    4,    4,    4,    4,
 /*    60 */     5,   15,   15,   15,    8,    8,    8,   10,   16,    4,
 /*    70 */     4,    4,    4,    4,    4,    5,   15,   15,   15,    8,
 /*    80 */     8,    8,   10,   16,   39,   71,   66,   91,    7,    6,
 /*    90 */     8,    8,    8,   10,   16,   23,    4,    4,    4,    4,
 /*   100 */     4,    4,    5,   15,   15,   15,    8,    8,    8,   10,
 /*   110 */    16,    6,   31,   31,   14,   35,   12,    1,    4,    4,
 /*   120 */     4,    4,    4,    4,    5,   15,   15,   15,    8,    8,
 /*   130 */     8,   10,   16,    4,    4,    4,    4,    4,    5,   15,
 /*   140 */    15,   15,    8,    8,    8,   10,   16,   24,  153,   38,
 /*   150 */    88,   68,   80,   18,   17,   44,   68,   21,   19,   30,
 /*   160 */    15,   15,   15,    8,    8,    8,   10,   16,   24,    9,
 /*   170 */    69,   43,   74,   74,   18,   80,   67,   80,   21,   19,
 /*   180 */    30,   24,   82,   80,   77,   76,   98,   18,   10,   16,
 /*   190 */    76,   21,   19,   30,   26,   13,   85,   51,   60,   40,
 /*   200 */    41,   81,   65,   27,   67,   70,   63,   40,   41,    3,
 /*   210 */    94,   89,   67,   60,   24,   78,   81,   83,   99,   99,
 /*   220 */    18,    2,   22,   37,   21,   19,   30,   29,   31,   31,
 /*   230 */    14,   96,   58,   40,   41,   81,   94,   89,   67,   11,
 /*   240 */     3,   25,   64,   85,   51,   60,   36,   57,   81,   65,
 /*   250 */    81,   40,   41,   62,   94,   89,   67,  118,  118,   85,
 /*   260 */    51,   60,   84,  118,   81,   65,   24,  118,   73,   86,
 /*   270 */    72,   81,   18,  118,  118,   24,   21,   19,   30,   60,
 /*   280 */   118,   18,   81,   93,  118,   21,   19,   30,  118,   85,
 /*   290 */    34,   60,  118,  118,   81,   65,   85,   53,   60,  118,
 /*   300 */    39,   81,   65,   87,   85,   52,   60,  118,  118,   81,
 /*   310 */    65,  118,   85,   61,   60,  118,  118,   81,   65,   85,
 /*   320 */    55,   60,  118,  118,   81,   65,  118,  118,   85,   33,
 /*   330 */    60,  118,  118,   81,   65,  118,  118,  118,   85,   46,
 /*   340 */    60,  118,  118,   81,   65,  118,  118,   85,   56,   60,
 /*   350 */   118,  118,   81,   65,   85,   95,   60,  118,  118,   81,
 /*   360 */    65,  118,   85,   54,   60,  118,  118,   81,   65,  118,
 /*   370 */    85,   97,   60,  118,  118,   81,   65,   85,   50,   60,
 /*   380 */   118,  118,   81,   65,  118,  118,   85,   49,   60,  118,
 /*   390 */   118,   81,   65,   60,  118,   42,   81,   83,  118,  118,
 /*   400 */   118,  118,   22,  118,  118,   85,   47,   60,  118,  118,
 /*   410 */    81,   65,  118,   45,  118,   75,  118,   60,  118,  118,
 /*   420 */    81,   65,  118,   85,   48,   60,  118,  118,   81,   65,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,    3,   39,   40,   16,   42,   43,   44,   10,   11,
 /*    10 */    12,   13,   14,   15,   16,   17,   18,   19,   20,   21,
 /*    20 */    22,   23,   24,    2,    3,   54,   28,   54,   57,   58,
 /*    30 */    57,   10,   11,   12,   13,   14,   15,   16,   17,   18,
 /*    40 */    19,   20,   21,   22,   23,   24,    2,    3,   25,   28,
 /*    50 */     7,    8,    9,   47,   10,   11,   12,   13,   14,   15,
 /*    60 */    16,   17,   18,   19,   20,   21,   22,   23,   24,   10,
 /*    70 */    11,   12,   13,   14,   15,   16,   17,   18,   19,   20,
 /*    80 */    21,   22,   23,   24,   57,   41,   59,   60,    2,    3,
 /*    90 */    20,   21,   22,   23,   24,    5,   10,   11,   12,   13,
 /*   100 */    14,   15,   16,   17,   18,   19,   20,   21,   22,   23,
 /*   110 */    24,    3,    7,    8,    9,   47,   11,   27,   10,   11,
 /*   120 */    12,   13,   14,   15,   16,   17,   18,   19,   20,   21,
 /*   130 */    22,   23,   24,   11,   12,   13,   14,   15,   16,   17,
 /*   140 */    18,   19,   20,   21,   22,   23,   24,   26,   46,   47,
 /*   150 */    61,   30,   48,   32,   33,   34,   35,   36,   37,   38,
 /*   160 */    17,   18,   19,   20,   21,   22,   23,   24,   26,    1,
 /*   170 */    57,   29,   30,   31,   32,   48,   44,   48,   36,   37,
 /*   180 */    38,   26,   55,   48,   55,   30,   51,   32,   23,   24,
 /*   190 */    35,   36,   37,   38,   47,   27,   52,   53,   54,   39,
 /*   200 */    40,   57,   58,   47,   44,   57,   62,   39,   40,    6,
 /*   210 */    42,   43,   44,   54,   26,   56,   57,   58,   30,   31,
 /*   220 */    32,   27,   63,   47,   36,   37,   38,    6,    7,    8,
 /*   230 */     9,   28,   54,   39,   40,   57,   42,   43,   44,   27,
 /*   240 */     6,   25,   49,   52,   53,   54,   47,   54,   57,   58,
 /*   250 */    57,   39,   40,   62,   42,   43,   44,   64,   64,   52,
 /*   260 */    53,   54,   28,   64,   57,   58,   26,   64,   54,   62,
 /*   270 */    30,   57,   32,   64,   64,   26,   36,   37,   38,   54,
 /*   280 */    64,   32,   57,   58,   64,   36,   37,   38,   64,   52,
 /*   290 */    53,   54,   64,   64,   57,   58,   52,   53,   54,   64,
 /*   300 */    57,   57,   58,   60,   52,   53,   54,   64,   64,   57,
 /*   310 */    58,   64,   52,   53,   54,   64,   64,   57,   58,   52,
 /*   320 */    53,   54,   64,   64,   57,   58,   64,   64,   52,   53,
 /*   330 */    54,   64,   64,   57,   58,   64,   64,   64,   52,   53,
 /*   340 */    54,   64,   64,   57,   58,   64,   64,   52,   53,   54,
 /*   350 */    64,   64,   57,   58,   52,   53,   54,   64,   64,   57,
 /*   360 */    58,   64,   52,   53,   54,   64,   64,   57,   58,   64,
 /*   370 */    52,   53,   54,   64,   64,   57,   58,   52,   53,   54,
 /*   380 */    64,   64,   57,   58,   64,   64,   52,   53,   54,   64,
 /*   390 */    64,   57,   58,   54,   64,   56,   57,   58,   64,   64,
 /*   400 */    64,   64,   63,   64,   64,   52,   53,   54,   64,   64,
 /*   410 */    57,   58,   64,   50,   64,   52,   64,   54,   64,   64,
 /*   420 */    57,   58,   64,   52,   53,   54,   64,   64,   57,   58,
);
    const YY_SHIFT_USE_DFLT = -38;
    const YY_SHIFT_MAX = 66;
    static public $yy_shift_ofst = array(
 /*     0 */   -38,  168,  168,  168,  168,  168,  168,  168,  168,  168,
 /*    10 */   168,  168,  168,  168,  168,  168,  168,  168,  168,  194,
 /*    20 */   212,  194,  -37,  -37,  160,  132,  121,  121,  142,  160,
 /*    30 */   160,  160,  132,   86,   86,  188,  155,  240,  249,   90,
 /*    40 */   132,  132,  -38,  -38,  -38,  -38,   44,   21,   -2,   86,
 /*    50 */    86,   86,  108,   59,  122,  143,   70,  221,  105,   43,
 /*    60 */    43,  165,  234,  203,  -12,  216,   23,
);
    const YY_REDUCE_USE_DFLT = -30;
    const YY_REDUCE_MAX = 45;
    static public $yy_reduce_ofst = array(
 /*     0 */   102,  191,  144,  207,  310,  267,  244,  252,  260,  325,
 /*    10 */   318,  371,  334,  353,  286,  295,  302,  276,  237,  339,
 /*    20 */   363,  159,  225,  -29,  193,   27,  129,  127,  135,  -27,
 /*    30 */   178,  214,  243,  147,  156,  104,  104,  104,  104,   89,
 /*    40 */   113,  148,  176,   68,  199,    6,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 2 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 3 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 4 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 5 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 6 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 7 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 8 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 9 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 10 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 11 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 12 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 13 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 14 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 15 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 16 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 17 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 18 */ array(1, 27, 39, 40, 42, 43, 44, ),
        /* 19 */ array(27, 39, 40, 42, 43, 44, ),
        /* 20 */ array(27, 39, 40, 42, 43, 44, ),
        /* 21 */ array(27, 39, 40, 42, 43, 44, ),
        /* 22 */ array(39, 40, 42, 43, 44, ),
        /* 23 */ array(39, 40, 42, 43, 44, ),
        /* 24 */ array(39, 40, 44, ),
        /* 25 */ array(44, ),
        /* 26 */ array(26, 30, 32, 33, 34, 35, 36, 37, 38, ),
        /* 27 */ array(26, 30, 32, 33, 34, 35, 36, 37, 38, ),
        /* 28 */ array(26, 29, 30, 31, 32, 36, 37, 38, ),
        /* 29 */ array(39, 40, 44, ),
        /* 30 */ array(39, 40, 44, ),
        /* 31 */ array(39, 40, 44, ),
        /* 32 */ array(44, ),
        /* 33 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 34 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 35 */ array(26, 30, 31, 32, 36, 37, 38, ),
        /* 36 */ array(26, 30, 32, 35, 36, 37, 38, ),
        /* 37 */ array(26, 30, 32, 36, 37, 38, ),
        /* 38 */ array(26, 32, 36, 37, 38, ),
        /* 39 */ array(5, 27, ),
        /* 40 */ array(44, ),
        /* 41 */ array(44, ),
        /* 42 */ array(),
        /* 43 */ array(),
        /* 44 */ array(),
        /* 45 */ array(),
        /* 46 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 41, ),
        /* 47 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 28, ),
        /* 48 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 28, ),
        /* 49 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 50 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 51 */ array(2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 52 */ array(3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 53 */ array(10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 54 */ array(11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 55 */ array(17, 18, 19, 20, 21, 22, 23, 24, ),
        /* 56 */ array(20, 21, 22, 23, 24, ),
        /* 57 */ array(6, 7, 8, 9, ),
        /* 58 */ array(7, 8, 9, 11, ),
        /* 59 */ array(7, 8, 9, ),
        /* 60 */ array(7, 8, 9, ),
        /* 61 */ array(23, 24, ),
        /* 62 */ array(6, 28, ),
        /* 63 */ array(6, 28, ),
        /* 64 */ array(16, ),
        /* 65 */ array(25, ),
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
);
    static public $yy_default = array(
 /*     0 */   102,  152,  152,  152,  152,  152,  152,  152,  152,  152,
 /*    10 */   152,  152,  152,  152,  152,  152,  152,  152,  152,  142,
 /*    20 */   152,  142,  144,  152,  152,  152,  152,  152,  152,  152,
 /*    30 */   152,  152,  152,  102,  102,  152,  152,  152,  100,  147,
 /*    40 */   152,  152,  102,  102,  102,  102,  152,  152,  152,  116,
 /*    50 */   122,  151,  123,  124,  125,  126,  128,  106,  152,  107,
 /*    60 */   135,  127,  152,  152,  152,  134,  133,  138,  113,  118,
 /*    70 */   119,  121,  115,  120,  109,  104,  112,  111,  114,  105,
 /*    80 */   101,  117,  110,  146,  149,  132,  150,  139,  141,  137,
 /*    90 */   148,  140,  131,  145,  136,  129,  143,  130,  103,  108,
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
    const YYNOCODE = 65;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 100;
    const YYNRULE = 52;
    const YYERRORSYMBOL = 45;
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
  'T_BITWISE',     'T_FILTER_PIPE',  'T_FOR',         'T_LPARENT',   
  'T_RPARENT',     'T_EMPTY',       'T_END',         'T_ENDFOR',    
  'T_IF',          'T_ELIF',        'T_ELSE',        'T_ENDIF',     
  'T_TAG',         'T_TAG_BLOCK',   'T_SET',         'T_DOLLAR',    
  'T_AT',          'T_BRACKETS_CLOSE',  'T_NUMBER',      'T_STRING',    
  'T_ALPHA',       'error',         'start',         'body',        
  'code',          'for_dest',      'for_source',    'for_end',     
  'term',          'expr',          'variable',      'if_end',      
  'arguments_list',  'alpha',         'term_simple',   'filters',     
  'filter',        'arguments',     'args',          'term_list',   
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= body",
 /*   1 */ "body ::= body code",
 /*   2 */ "body ::=",
 /*   3 */ "code ::= T_FOR for_dest T_IN for_source body for_end",
 /*   4 */ "for_source ::= term",
 /*   5 */ "for_source ::= T_LPARENT expr T_RPARENT",
 /*   6 */ "for_dest ::= variable",
 /*   7 */ "for_dest ::= variable T_COMMA variable",
 /*   8 */ "for_end ::= T_EMPTY body T_END|T_ENDFOR",
 /*   9 */ "for_end ::= T_END|T_ENDFOR",
 /*  10 */ "code ::= T_IF expr body if_end",
 /*  11 */ "if_end ::= T_ELIF expr body if_end",
 /*  12 */ "if_end ::= T_ELSE body T_END|T_ENDIF",
 /*  13 */ "if_end ::= T_END|T_ENDIF",
 /*  14 */ "code ::= T_TAG arguments_list",
 /*  15 */ "code ::= T_TAG_BLOCK arguments_list body T_END",
 /*  16 */ "code ::= T_SET variable T_EQ expr",
 /*  17 */ "variable ::= alpha",
 /*  18 */ "variable ::= T_DOLLAR alpha",
 /*  19 */ "variable ::= T_AT alpha",
 /*  20 */ "variable ::= variable T_DOT|T_OBJ variable",
 /*  21 */ "variable ::= variable T_BRACKETS_OPEN expr T_BRACKETS_CLOSE",
 /*  22 */ "expr ::= T_NOT expr",
 /*  23 */ "expr ::= expr T_AND expr",
 /*  24 */ "expr ::= expr T_OR expr",
 /*  25 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE expr",
 /*  26 */ "expr ::= expr T_IN expr",
 /*  27 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  28 */ "expr ::= expr T_PLUS|T_MINUS|T_CONCAT expr",
 /*  29 */ "expr ::= expr T_BITWISE expr",
 /*  30 */ "expr ::= expr T_PIPE expr",
 /*  31 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  32 */ "expr ::= term",
 /*  33 */ "term ::= term_simple T_FILTER_PIPE filters",
 /*  34 */ "term ::= term_simple",
 /*  35 */ "term_simple ::= variable",
 /*  36 */ "term_simple ::= T_NUMBER",
 /*  37 */ "term_simple ::= T_STRING",
 /*  38 */ "alpha ::= T_ALPHA",
 /*  39 */ "filters ::= filters T_FILTER_PIPE filter",
 /*  40 */ "filters ::= filter",
 /*  41 */ "filter ::= alpha arguments",
 /*  42 */ "arguments_list ::=",
 /*  43 */ "arguments_list ::= T_LPARENT args T_RPARENT",
 /*  44 */ "arguments_list ::= term_list",
 /*  45 */ "term_list ::= term_list term_simple",
 /*  46 */ "term_list ::= term_simple",
 /*  47 */ "arguments ::=",
 /*  48 */ "arguments ::= T_COLON term_simple",
 /*  49 */ "arguments ::= T_LPARENT args T_RPARENT",
 /*  50 */ "args ::= args T_COMMA args",
 /*  51 */ "args ::= expr",
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
  array( 'lhs' => 46, 'rhs' => 1 ),
  array( 'lhs' => 47, 'rhs' => 2 ),
  array( 'lhs' => 47, 'rhs' => 0 ),
  array( 'lhs' => 48, 'rhs' => 6 ),
  array( 'lhs' => 50, 'rhs' => 1 ),
  array( 'lhs' => 50, 'rhs' => 3 ),
  array( 'lhs' => 49, 'rhs' => 1 ),
  array( 'lhs' => 49, 'rhs' => 3 ),
  array( 'lhs' => 51, 'rhs' => 3 ),
  array( 'lhs' => 51, 'rhs' => 1 ),
  array( 'lhs' => 48, 'rhs' => 4 ),
  array( 'lhs' => 55, 'rhs' => 4 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 48, 'rhs' => 2 ),
  array( 'lhs' => 48, 'rhs' => 4 ),
  array( 'lhs' => 48, 'rhs' => 4 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 2 ),
  array( 'lhs' => 54, 'rhs' => 2 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 4 ),
  array( 'lhs' => 53, 'rhs' => 2 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 3 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 58, 'rhs' => 1 ),
  array( 'lhs' => 58, 'rhs' => 1 ),
  array( 'lhs' => 58, 'rhs' => 1 ),
  array( 'lhs' => 57, 'rhs' => 1 ),
  array( 'lhs' => 59, 'rhs' => 3 ),
  array( 'lhs' => 59, 'rhs' => 1 ),
  array( 'lhs' => 60, 'rhs' => 2 ),
  array( 'lhs' => 56, 'rhs' => 0 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 2 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 0 ),
  array( 'lhs' => 61, 'rhs' => 2 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 62, 'rhs' => 1 ),
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
        47 => 2,
        3 => 3,
        4 => 4,
        32 => 4,
        34 => 4,
        35 => 4,
        38 => 4,
        44 => 4,
        5 => 5,
        12 => 5,
        43 => 5,
        49 => 5,
        6 => 6,
        40 => 6,
        46 => 6,
        48 => 6,
        51 => 6,
        7 => 7,
        8 => 8,
        10 => 10,
        11 => 10,
        14 => 14,
        15 => 15,
        16 => 16,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 23,
        25 => 23,
        27 => 23,
        28 => 23,
        29 => 23,
        26 => 26,
        30 => 30,
        31 => 31,
        33 => 33,
        36 => 36,
        37 => 37,
        39 => 39,
        41 => 41,
        45 => 45,
        50 => 50,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 82 "lib/Haanga2/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1157 "lib/Haanga2/Compiler/Parser.php"
#line 84 "lib/Haanga2/Compiler/Parser.y"
    function yy_r1(){ $this->yystack[$this->yyidx + -1]->minor[] = $this->yystack[$this->yyidx + 0]->minor; $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1160 "lib/Haanga2/Compiler/Parser.php"
#line 85 "lib/Haanga2/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1163 "lib/Haanga2/Compiler/Parser.php"
#line 88 "lib/Haanga2/Compiler/Parser.y"
    function yy_r3(){ $this->_retvalue = new Term\For($this->yystack[$this->yyidx + -4]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1166 "lib/Haanga2/Compiler/Parser.php"
#line 89 "lib/Haanga2/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1169 "lib/Haanga2/Compiler/Parser.php"
#line 90 "lib/Haanga2/Compiler/Parser.y"
    function yy_r5(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1172 "lib/Haanga2/Compiler/Parser.php"
#line 91 "lib/Haanga2/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1175 "lib/Haanga2/Compiler/Parser.php"
#line 92 "lib/Haanga2/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -2]->minor);     }
#line 1178 "lib/Haanga2/Compiler/Parser.php"
#line 93 "lib/Haanga2/Compiler/Parser.y"
    function yy_r8(){ A = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1181 "lib/Haanga2/Compiler/Parser.php"
#line 98 "lib/Haanga2/Compiler/Parser.y"
    function yy_r10(){ $this->_retvalue = new Code\opIf($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1184 "lib/Haanga2/Compiler/Parser.php"
#line 104 "lib/Haanga2/Compiler/Parser.y"
    function yy_r14(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1187 "lib/Haanga2/Compiler/Parser.php"
#line 105 "lib/Haanga2/Compiler/Parser.y"
    function yy_r15(){ $this->_retvalue = new Tag($this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1190 "lib/Haanga2/Compiler/Parser.php"
#line 108 "lib/Haanga2/Compiler/Parser.y"
    function yy_r16(){ $this->_retvalue = new DefVariable($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1193 "lib/Haanga2/Compiler/Parser.php"
#line 112 "lib/Haanga2/Compiler/Parser.y"
    function yy_r17(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor);     }
#line 1196 "lib/Haanga2/Compiler/Parser.php"
#line 113 "lib/Haanga2/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, 'object');     }
#line 1199 "lib/Haanga2/Compiler/Parser.php"
#line 114 "lib/Haanga2/Compiler/Parser.y"
    function yy_r19(){ $this->_retvalue = new Variable($this->yystack[$this->yyidx + 0]->minor, 'array');     }
#line 1202 "lib/Haanga2/Compiler/Parser.php"
#line 115 "lib/Haanga2/Compiler/Parser.y"
    function yy_r20(){ $this->yystack[$this->yyidx + -2]->minor->addPart($this->yystack[$this->yyidx + 0]->minor, 'object'); $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor;     }
#line 1205 "lib/Haanga2/Compiler/Parser.php"
#line 116 "lib/Haanga2/Compiler/Parser.y"
    function yy_r21(){ $this->yystack[$this->yyidx + -3]->minor->addPart($this->yystack[$this->yyidx + -1]->minor, 'array'); $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor ;     }
#line 1208 "lib/Haanga2/Compiler/Parser.php"
#line 120 "lib/Haanga2/Compiler/Parser.y"
    function yy_r22(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + 0]->minor, 'not');     }
#line 1211 "lib/Haanga2/Compiler/Parser.php"
#line 121 "lib/Haanga2/Compiler/Parser.y"
    function yy_r23(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1214 "lib/Haanga2/Compiler/Parser.php"
#line 124 "lib/Haanga2/Compiler/Parser.y"
    function yy_r26(){ $this->_retvalue = new Expr\In($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1217 "lib/Haanga2/Compiler/Parser.php"
#line 128 "lib/Haanga2/Compiler/Parser.y"
    function yy_r30(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -2]->minor, @X, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1220 "lib/Haanga2/Compiler/Parser.php"
#line 129 "lib/Haanga2/Compiler/Parser.y"
    function yy_r31(){ $this->_retvalue = new Expr($this->yystack[$this->yyidx + -1]->minor);     }
#line 1223 "lib/Haanga2/Compiler/Parser.php"
#line 134 "lib/Haanga2/Compiler/Parser.y"
    function yy_r33(){ $this->_retvalue = new Term\Filter($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1226 "lib/Haanga2/Compiler/Parser.php"
#line 137 "lib/Haanga2/Compiler/Parser.y"
    function yy_r36(){ $this->_retvalue = new Term\Number($this->yystack[$this->yyidx + 0]->minor);     }
#line 1229 "lib/Haanga2/Compiler/Parser.php"
#line 138 "lib/Haanga2/Compiler/Parser.y"
    function yy_r37(){ $this->_retvalue = new Term\String($this->yystack[$this->yyidx + 0]->minor) ;     }
#line 1232 "lib/Haanga2/Compiler/Parser.php"
#line 144 "lib/Haanga2/Compiler/Parser.y"
    function yy_r39(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1235 "lib/Haanga2/Compiler/Parser.php"
#line 146 "lib/Haanga2/Compiler/Parser.y"
    function yy_r41(){ $this->_retvalue = new Filter($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1238 "lib/Haanga2/Compiler/Parser.php"
#line 153 "lib/Haanga2/Compiler/Parser.y"
    function yy_r45(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1241 "lib/Haanga2/Compiler/Parser.php"
#line 160 "lib/Haanga2/Compiler/Parser.y"
    function yy_r50(){ $this->_retvalue = array_merge($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1244 "lib/Haanga2/Compiler/Parser.php"

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
#line 1364 "lib/Haanga2/Compiler/Parser.php"
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

#line 1385 "lib/Haanga2/Compiler/Parser.php"
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
