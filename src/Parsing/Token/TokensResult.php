<?php


namespace Phocate\Parsing\Token;


use Phocate\Parsing\EitherResult;
use Phocate\Parsing\StringResult;

interface TokensResult
{
    public function mapToStringResult(callable $closure): StringResult;
    public function mapToEitherResult(callable $closure): EitherResult;
}