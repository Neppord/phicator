<?php
declare(strict_types = 1);

namespace Phocate;


class LiftTokenToMany extends TokensParser
{
    /** @var TokenParser */
    private $token_parser;

    public function __construct(TokenParser $token_parser)
    {
        $this->token_parser = $token_parser;
    }

    public function parse(Tokens $tokens): ?TokensResult
    {
        $result = $this->token_parser->parse($tokens);
        if ($result === null) {
            return null;
        } else {
            return new TokensResult([$result->token], $result->tokens);
        }
    }
}