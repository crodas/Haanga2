<?php

class TokenizerTest extends \phpunit_framework_testcase
{
    public function testTokenizer()
    {
        $code = <<<EOF
{{1+1}} {{"cesar"|upper}}
{% escape %}foo{% endescape %}
something else
EOF;
        $tokenizer = new \Haanga2\Compiler\Tokenizer;
        $tokens    = $tokenizer->tokenize($code);
        $this->assertTrue(is_array($tokens));
        $this->assertTrue(count($tokens) > 0);
        //var_dump($tokens);exit;
    }
}
