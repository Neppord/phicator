<?php
namespace Phocate;

class FailedResult implements ParseResult
{

    public function succeeded(): bool
    {
        return false;
    }

    public function tokens(): Tokens
    {
        return null;
    }
}
