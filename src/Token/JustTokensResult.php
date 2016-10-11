<?php
declare(strict_types = 1);

namespace Phocate\Token;


use Phocate\JustStringResult;
use Phocate\StringResult;

class JustTokensResult implements TokensResult
{
    /** @var Token[] */
    public $result;
    /** @var Tokens */
    public $tokens;

    public function __construct(array $result, Tokens $tokens)
    {
        $this->result = $result;
        $this->tokens = $tokens;
    }

    public function mapToStringResult(callable $closure): StringResult
    {
        return new JustStringResult(
            $closure($this->result),
            $this->tokens
        );
    }
}