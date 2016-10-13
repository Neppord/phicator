<?php
declare(strict_types = 1);

namespace Phocate\Parsing;


use Phocate\Parsing\Token\Tokens;

class BindStringParser extends StringParser
{

    /** @var StringParser */
    private $from;
    /** @var callable */
    private $through;

    public function __construct(
        StringParser $from,
        callable $through
    ){
        $this->from = $from;
        $this->through = $through;
    }

    public function parse(Tokens $tokens): StringResult
    {
        $result = $this->from->parse($tokens);
        if ($result instanceof JustStringResult) {
            $through = $this->through;
            return $through($result->result)->parse($result->tokens);
        } else {
            return $result;
        }
    }
}