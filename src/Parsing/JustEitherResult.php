<?php
declare(strict_types = 1);

namespace Phocate\Parsing;


use Phocate\Parsing\Token\Tokens;

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