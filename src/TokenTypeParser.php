<?php
namespace Phocate;

class TokenTypeParser extends TokenParser
{
    /** @var int */
    private $type;

    public function __construct(int $type)
    {
        $this->type = $type;
    }

    public function parse(Tokens $tokens): ?TokenResult
    {
        $head = $tokens->head();
        if ($head->type === $this->type) {
            return new TokenResult($head, $tokens->tail());
        } else {
            return null;
        }
    }
}
