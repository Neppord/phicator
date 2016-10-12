<?php
declare(strict_types = 1);

namespace Phocate\Token;


use Phocate\EitherResult;
use Phocate\NothingEitherResult;
use Phocate\StringResult;
use Phocate\NothingStringResult;

class NothingTokensResult implements TokensResult
{

    public function mapToStringResult(callable $closure): StringResult
    {
        return new NothingStringResult();
    }

    public function mapToEitherResult(callable $closure): EitherResult
    {
        return new NothingEitherResult();
    }
}