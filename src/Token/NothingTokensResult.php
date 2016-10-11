<?php
declare(strict_types = 1);

namespace Phocate\Token;


use Phocate\StringResult;
use Phocate\NothingStringResult;

class NothingTokensResult implements TokensResult
{

    public function mapToStringResult(callable $closure): StringResult
    {
        return new NothingStringResult();
    }
}