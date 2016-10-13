<?php
declare(strict_types = 1);

namespace Phocate;


use Phocate\Token\Tokens;

class JustEitherResult implements EitherResult
{
    /** @var Either */
    public $result;
    /** @var Tokens */
    public $tokens;

    public function __construct(Either $result, Tokens $tokens)
    {
        $this->result = $result;
        $this->tokens = $tokens;
    }
}