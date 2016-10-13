<?php
declare(strict_types = 1);

namespace Phocate\Parsing;


use Phocate\Parsing\Token\IfFailEitherParser;
use Phocate\Parsing\Token\Tokens;

abstract class EitherParser
{
    abstract public function parse(Tokens $tokens): EitherResult;

    public function ifFail(EitherParser $other)
    {
        return new IfFailEitherParser($this, $other);
    }
}