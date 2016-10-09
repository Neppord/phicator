<?php
declare(strict_types=1);

namespace Phocate;


interface Parser
{
    public function parse(Tokens $tokens): ParseResult;
}