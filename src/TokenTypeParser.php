<?php
namespace Phocate;

class TokenTypeParser extends Parser
{
    /** @var int */
    private $type;

    public function __construct(int $type)
    {
        $this->type = $type;
    }

    public function parse(Tokens $tokens): ParseResult
    {
        $head = $tokens->head();
        if ($head->type === $this->type) {
            return new TokenResult($head, $tokens->tail());
        } else {
            return new FailedResult();
        }
    }
}
