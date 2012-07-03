<?php

use Haanga2_Compiler_Parser as Parser;

class TokenizerTest extends \phpunit_framework_testcase
{
    public function testTokenizer()
    {
        $code = <<<EOF
{{1+1}} {{"'foo\"bar"|upper}}
{% for i in foo %}foo{% endfor
    
    

%} something else
EOF;
        $tokenizer = new \Haanga2\Compiler\Tokenizer;
        $tokens    = $tokenizer->tokenize($code);
        $this->assertTrue(is_array($tokens));
        $this->assertTrue(count($tokens) > 0);


        $this->assertEquals(array(Parser::T_NUMBER, 1, 1), $tokens[0]);
        $this->assertEquals(array(Parser::T_PLUS, '+', 1), $tokens[1]);
        $this->assertEquals(array(Parser::T_NUMBER, 1, 1), $tokens[2]);
        $this->assertEquals(array(Parser::T_HTML, " ", 1), $tokens[3]);
        $this->assertEquals(array(Parser::T_STRING, "'foo\"bar", 1), $tokens[4]);
        $this->assertEquals(array(Parser::T_FILTER_PIPE, "|", 1), $tokens[5]);
        $this->assertEquals(array(Parser::T_ALPHA, "upper", 1), $tokens[6]);
        $this->assertEquals(array(Parser::T_HTML, "\n", 1), $tokens[7]);
        $this->assertEquals(array(Parser::T_FOR, "for", 2), $tokens[8]);
        $this->assertEquals(array(Parser::T_ALPHA, "i", 2), $tokens[9]);
        $this->assertEquals(array(Parser::T_IN, "in", 2), $tokens[10]);
        $this->assertEquals(array(Parser::T_ALPHA, "foo", 2), $tokens[11]);
        $this->assertEquals(array(Parser::T_HTML, "foo", 2), $tokens[12]);
        $this->assertEquals(array(Parser::T_ENDFOR, "endfor", 2), $tokens[13]);
        $this->assertEquals(array(Parser::T_HTML, " something else", 6), $tokens[14]);
    }
}
