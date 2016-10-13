<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Token;


use Phocate\Parsing\StringParser;
use Phocate\Parsing\StringResult;

class MapTokenParserToStringParser extends StringParser
{

    /** @var TokensParser */
    private $token_parser;
    /** @var callable */
    private $closure;

    public function __construct(
        TokensParser $token_parser,
        callable $closure
    ) {
        $this->token_parser = $token_parser;
        $this->closure = $closure;
    }

    public function parse(Tokens $tokens): StringResult
    {
        return $this->token_parser
            ->parse($tokens)
            ->mapToStringResult($this->closure);
    }
}