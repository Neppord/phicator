<?php
declare(strict_types = 1);

namespace Phocate\Token;


class JustTokensResult implements TokensResult
{
    /** @var Token[] */
    public $result;
    /** @var Tokens */
    public $tokens;

    public function __construct(array $result, Tokens $tokens)
    {
        $this->result = $result;
        $this->tokens = $tokens;
    }
}