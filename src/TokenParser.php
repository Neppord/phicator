<?php
declare(strict_types = 1);

namespace Phocate;


abstract class TokenParser
{
    abstract public function parse(Tokens $tokens): ?TokenResult;

    public function bind(callable $closure): TokenParser
    {
        return new BindTokenParser($this, $closure);
    }
}