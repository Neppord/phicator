<?php


namespace Phocate\Token;


use Phocate\EitherResult;
use Phocate\StringResult;

interface TokensResult
{
    public function mapToStringResult(callable $closure): StringResult;
    public function mapToEitherResult(callable $closure): EitherResult;
}