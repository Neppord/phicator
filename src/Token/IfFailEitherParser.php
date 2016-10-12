<?php
declare(strict_types = 1);

namespace Phocate\Token;


use Phocate\EitherResult;
use Phocate\NothingEitherResult;

class IfFailEitherParser extends EitherParser
{

    /** @var IfFailEitherParser */
    private $first;
    /** @var EitherParser */
    private $other;

    public function __construct(
        EitherParser $first,
        EitherParser $other
    ) {
        $this->first = $first;
        $this->other = $other;
    }

    public function parse(Tokens $tokens): EitherResult
    {
        $result = $this->first->parse($tokens);
        if ($result instanceof NothingEitherResult) {
            return $this->other->parse($tokens);
        } else {
            return $result;
        }
    }
}