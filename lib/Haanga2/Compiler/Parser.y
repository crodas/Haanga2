%name Haanga2_
%include {
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

}

%declare_class { class Haanga2_Compiler_Parser }
%include_class {
    protected $lex;
    protected $file;

    function Error($text)
    {
        throw new \RuntimeException($text);
    }

}

%parse_accept {
}

%right T_NOT.
%left T_AND.
%left T_OR.
%left T_QUESTION T_COLON.
%left T_COMMA.
%left T_DOT T_OBJ T_BRACKET_OPEN. 
%nonassoc T_NE.
%nonassoc T_EQ.
%nonassoc T_GT T_GE T_LT T_LE.
%left T_IN .
%left T_PLUS T_MINUS T_CONCAT.
%left T_TIMES T_DIV T_MOD.
%left T_PIPE T_BITWISE T_FILTER_PIPE.

%syntax_error {
    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. ')');
}

start ::= body(B) . { $this->body = B; }

body(A) ::= body(B) code(C) . { B[] = C; A = B; }
body(A) ::= . { A = array(); }

code(A) ::= T_HTML(B) . { A = new DoPrint(new Term\String(B)); }

code(A) ::= T_ECHO expr(X) . { A = new DoPrint(X); }

// for loop {{{
code(A) ::= T_FOR for_dest(X) T_IN for_source(C) body(Y) for_end(Z). { A = new DoFor(X, C, Y, Z); }
for_source(A) ::= term(B) . { A = B; }
for_source(A) ::= T_LPARENT expr(B) T_RPARENT . { A = B; }
for_dest(A) ::= variable(X) . { A = array(X); }
for_dest(A) ::= variable(X) T_COMMA variable(Y) . { A = array(Y, X); }
for_end(A)  ::= T_EMPTY body(X) T_END|T_ENDFOR . { A = X; }
for_end(A)  ::= T_END|T_ENDFOR . { A = array(); }
// }}}

// if {{{
code(A) ::= T_IF expr(B) body(C) if_end(X). { A = new DoIf(B, C, X); }
if_end(A) ::= T_ELIF expr(B) body(C) if_end(X) . { A = array(new DoIf(B, C, X)); }
if_end(A) ::= T_ELSE body(X) T_END|T_ENDIF . { A = X; }
if_end(A) ::= T_END|T_ENDIF . { A = array(); }
// }}}

// tags {{{
code(A) ::= T_TAG(B) arguments_list(C)  . { A = new Tag(B, C); }
code(A) ::= T_TAG_BLOCK(B) arguments_list(C) body(Y) T_END . { A = new Tag(B, C, Y); }
// }}}

// set {{{
code(A) ::= T_SET variable(B) T_ASSIGN expr(C) . { A = new DefVariable(B, C); }
// }}}

// variable {{{
variable(A) ::= variable(B) var_part(X) . { A = B; B->addPart(X[1], X[0]); }
variable(A) ::= variable(B) T_OBJ|T_DOT variable(C) . { A = B; A->addPart(C, Variable::T_DOT); }
variable(A) ::= alpha(B) . { A = new Variable(B); }
variable(A) ::= T_AT alpha(B) . { A = new Variable(B, Variable::T_ARRAY); }

var_part(A) ::= T_BRACKET_OPEN expr(C) T_BRACKET_CLOSE . { A = array(Variable::T_ARRAY, C); }
var_part(A) ::= T_CURLY_OPEN expr(C) T_CURLY_CLOSE . { A = array(Variable::T_OBJECT, C); }

// }}} 

// expr {{{
expr(A) ::= T_NOT expr(B). { A = new Expr(B, 'not'); }
expr(A) ::= expr(B) T_AND(X)  expr(C).  { A = new Expr(B, @X, C); }
expr(A) ::= expr(B) T_OR(X)  expr(C).  { A = new Expr(B, @X, C); }
expr(A) ::= expr(B) T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE(X)  expr(C).  { A = new Expr(B, @X, C); }
expr(A) ::= expr(B) T_IN expr(C) . { A = new Expr\In(B, C); }
expr(A) ::= expr(B) T_TIMES|T_DIV|T_MOD(X) expr(C) . { A = new Expr(B, @X, C); }
expr(A) ::= expr(B) T_PLUS|T_MINUS|T_CONCAT(X) expr(C) . { A = new Expr(B, @X, C); }
expr(A) ::= expr(B) T_BITWISE(X)  expr(C).  { A = new Expr(B, @X, C); }
expr(A) ::= expr(B) T_PIPE  expr(C).  { A = new Expr(B, @X, C); }
expr(A) ::= T_LPARENT expr(B) T_RPARENT . { A = new Expr(B); }
expr(A) ::= term(B) . { A = B; }
// }}} 

// term  {{{
term(A) ::= term_simple(B) T_FILTER_PIPE filters(X) . { A = new Term\Filter(B, X); }
term(A) ::= term_simple(B) . { A = B; }
term_simple(A) ::= json(B) . { A = new Term\Json(B); }
term_simple(A) ::= T_BOOL(X) . { A = new Term\Boolean(X); }
term_simple(A) ::= variable(B) . { A = B; }
term_simple(A) ::= T_NUMBER(B) . { A = new Term\Number(B); }
term_simple(A) ::= T_STRING(B) . { A = new Term\String(B) ; }
term_simple(A) ::= variable(B)  T_LPARENT args(C) T_RPARENT . { A = new Method(B, C); }

alpha(A) ::= T_ALPHA(X) . { A = X; }
// }}}

// json {{{
json(A) ::= T_CURLY_OPEN json_obj(B) T_CURLY_CLOSE. { A  = B; }
json(A) ::= T_BRACKET_OPEN json_arr(B) T_BRACKET_CLOSE. { A = B; }

json_obj(A) ::= json_obj(B) T_COMMA json_obj(C). { A = B; B[] = C; }
json_obj(A) ::= term_simple(B) T_COLON expr(C) . { A = array('key' => B, 'value' => C); } 

json_arr(X) ::= json_arr(A) T_COMMA expr(B) .  { X = A; X[] = B; }
json_arr(A) ::= expr(B). { A = array(B); }
// }}}

// term filter (nested) {{{ 
filters(A) ::= filters(B) T_FILTER_PIPE filter(C) . { A = B; A[] = C; }
filters(A) ::= filter(B) . { A = array(B); }
filter(A) ::= alpha(B) arguments(C) . { A = new Filter(B, C); }
// }}}

// function arguments {{{
arguments_list    ::= .
arguments_list(A) ::= T_LPARENT args(X) T_RPARENT . { A = X; }
arguments_list(A) ::= term_list(B) . { A = B; }
term_list(A) ::= term_list(B) term_simple(C) . { A = B; A[] = C; }
term_list(A) ::= term_simple(B) . { A = array(B); }/**/

arguments(A) ::= . { A = array(); }
arguments(A) ::= T_COLON term_simple(B)  . { A = array(B); }
arguments(A) ::= T_LPARENT args(X) T_RPARENT . { A = X; }

args(A) ::= args(B) T_COMMA args(C) . { A = array_merge(B, C); }
args(A) ::= expr(B)  . { A = array(B); }
args(A) ::= . { A = array(); }
// }}}

