<?php
declare(strict_types = 1);

namespace Phocate\Token;


use Phocate\EitherResult;

class MapTokenParserToEither extends EitherParser
{

    /** @var TokensParser */
    private $from;
    /** @var callable */
    private $through;

    public function __construct(
        TokensParser $from,
        callable $through
    ) {
        $this->from = $from;
        $this->through = $through;
    }

    public function parse(Tokens $tokens): EitherResult
    {
        $result = $this->from->parse($tokens);
        return $result->mapToEitherResult($this->through);
    }
}