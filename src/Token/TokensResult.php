<?php


namespace Phocate\Token;


use Phocate\StringResult;

interface TokensResult
{
    public function mapToStringResult(callable $closure): StringResult;
}