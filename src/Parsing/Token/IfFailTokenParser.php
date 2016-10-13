<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Token;


class IfFailTokenParser extends TokensParser
{

    /** @var TokensParser */
    private $first;
    /** @var TokensParser */
    private $other;

    public function __construct(
        TokensParser $first,
        TokensParser $other
    ) {
        $this->first = $first;
        $this->other = $other;
    }

    public function parse(Tokens $tokens): TokensResult
    {
        $result = $this->first->parse($tokens);
        if ($result instanceof NothingTokensResult) {
            return $this->other->parse($tokens);
        } else {
            return $result;
        }
    }
}