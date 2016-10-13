<?php
declare(strict_types = 1);

namespace Phocate;


use Phocate\Token\Tokens;

class PureEitherParser extends EitherParser
{

    /** @var Either */
    private $either;

    public function __construct(Either $either)
    {
        $this->either = $either;
    }

    public function parse(Tokens $tokens): EitherResult
    {
        return new JustEitherResult($this->either, $tokens);
    }
}