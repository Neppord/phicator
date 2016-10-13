<?php
declare(strict_types = 1);

namespace Phocate\Parsing;


use Phocate\Parsing\Token\Tokens;

abstract class StringParser
{
    abstract public function parse(Tokens $tokens): StringResult;

    public function bind(callable $closure)
    {
        return new BindStringParser($this, $closure);
    }
}