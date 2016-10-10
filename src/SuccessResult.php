<?php
namespace Phocate;

abstract class SuccessResult implements ParseResult
{

    public function succeeded(): bool
    {
        return true;
    }
    abstract public function tokens(): Tokens;
}
