<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Token;


use Phocate\Parsing\EitherResult;
use Phocate\Parsing\NothingEitherResult;
use Phocate\Parsing\NothingStringResult;
use Phocate\Parsing\StringResult;

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