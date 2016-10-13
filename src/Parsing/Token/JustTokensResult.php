<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Token;


use Phocate\Parsing\EitherResult;
use Phocate\Parsing\JustEitherResult;
use Phocate\Parsing\JustStringResult;
use Phocate\Parsing\StringResult;

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

    public function mapToEitherResult(callable $closure): EitherResult
    {
        return new JustEitherResult($closure($this->result), $this->tokens);
    }
}