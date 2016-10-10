<?php
namespace Phocate\Token;

class TokenResult
{
    /** @var Token */
    public $token;
    /** @var Tokens */
    public $tokens;

    public function __construct(Token $output, Tokens $tokens)
    {
        $this->token = $output;
        $this->tokens = $tokens;
    }
}
