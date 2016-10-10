<?php
declare(strict_types=1);

namespace Phocate;


abstract class Parser
{
    abstract public function parse(Tokens $tokens): ParseResult;
    public function before(Parser $other): Parser
    {
        return new BeforParser($this, $other);
    }
    public function or(Parser $other): Parser
    {
        return new OrParser($this, $other);
    }
}