<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Token;


use Phocate\Parsing\EitherParser;
use Phocate\Parsing\EitherResult;
use Phocate\Parsing\NothingEitherResult;

class BindTokensParserToEitherParser extends EitherParser
{
    /** @var TokensParser */
    private $from;
    /** @var callable */
    private $through;

    public function __construct(TokensParser $from, callable $through)
    {
        $this->from = $from;
        $this->through = $through;
    }

    public function parse(Tokens $tokens): EitherResult
    {
        $result = $this->from->parse($tokens);
        if ($result instanceof JustTokensResult) {
            $through = $this->through;
            return $through($result->result)->parse($result->tokens);
        } else {
            return new NothingEitherResult();
        }
    }
}