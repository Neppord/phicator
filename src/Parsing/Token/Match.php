<?php
namespace Phocate\Parsing\Token;

class Match extends TokensParser
{
    /** @var int */
    private $type;

    public function __construct(int $type)
    {
        $this->type = $type;
    }

    public function parse(Tokens $tokens): TokensResult
    {
        $head = $tokens->head();
        if ($head->type === $this->type) {
            return new JustTokensResult([$head], $tokens->tail());
        } else {
            return new NothingTokensResult();
        }
    }
}
