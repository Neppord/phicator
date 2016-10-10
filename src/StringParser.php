<?php
declare(strict_types = 1);

namespace Phocate;


abstract class StringParser
{
    abstract public function parse(Tokens $tokens): ?StringResult;
}