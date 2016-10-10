<?php
namespace Phocate;

class TokenResult extends SuccessResult
{
    /** @var mixed */
    private $output;
    /** @var Tokens */
    private $tokens;

    public function __construct(mixed $output, Tokens $tokens)
    {
        $this->output = $output;
        $this->tokens = $tokens;
    }

    public function output(): mixed
    {
        return $this->output;
    }

    public function tokens(): Tokens
    {
        return $this->tokens;
    }
}
