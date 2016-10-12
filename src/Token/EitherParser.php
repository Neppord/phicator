<?php
declare(strict_types = 1);

namespace Phocate\Token;


use Phocate\EitherResult;

abstract class EitherParser
{
    abstract public function parse(Tokens $tokens): EitherResult;

    public function ifFail(EitherParser $other)
    {
        return new IfFailEitherParser($this, $other);
    }
}