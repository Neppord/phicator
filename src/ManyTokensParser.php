<?php
declare(strict_types = 1);

namespace Phocate;


class ManyTokensParser extends TokensParser
{
    /** @var TokenParser */
    private $parser;

    /**
     * ManyTokenParser constructor.
     * @param TokenParser $parser
     */
    public function __construct(TokenParser $parser)
    {
        $this->parser = $parser;
    }

    public function parse(Tokens $tokens): ?TokensResult
    {
        $results = [];
        $result = $this->parser->parse($tokens);
        while ($result != null) {
            $results[] = $result->token;
            $tokens = $result->tokens;
            $result = $this->parser->parse($tokens);
        }
        return new TokensResult($results, $tokens);
    }
}