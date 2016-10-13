<?php
declare(strict_types = 1);

namespace Phocate\Parsing;


use Phocate\Parsing\Token\Tokens;

class JustStringResult implements StringResult
{
    /** @var string */
    public $result;
    /** @var Tokens */
    public $tokens;

    public function __construct(string $result, Tokens $tokens)
    {
        $this->result = $result;
        $this->tokens = $tokens;
    }
}