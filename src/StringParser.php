<?php
declare(strict_types = 1);

namespace Phocate;


use Phocate\Token\Tokens;

abstract class StringParser
{
    abstract public function parse(Tokens $tokens): ?StringResult;
}