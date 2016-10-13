<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Token;


class PureTokenParser extends TokensParser
{
    /** @var array */
    private $tokens;

    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    public function parse(Tokens $tokens): TokensResult
    {
        return new JustTokensResult($this->tokens, $tokens);
    }
}