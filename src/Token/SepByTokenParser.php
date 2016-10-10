<?php
declare(strict_types = 1);

namespace Phocate\Token;


class SepByTokenParser extends TokensParser
{
    /** @var TokensParser */
    private $parser;
    /** @var TokensParser */
    private $every_other;

    public function __construct(TokensParser $parser, TokensParser $sep_by)
    {
        $this->parser = $parser;
        $this->every_other = $sep_by->before($parser);
    }

    public function parse(Tokens $tokens): ?TokensResult
    {
        $results = [[]];
        $result = $this->parser->parse($tokens);
        if ($result === null) {
            return null;
        }
        while ($result != null) {
            $results[] = $result->result;
            $tokens = $result->tokens;
            $result = $this->every_other->parse($tokens);
        }
        return new TokensResult(array_merge(...$results), $tokens);
    }
}