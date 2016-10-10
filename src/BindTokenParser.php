<?php
declare(strict_types = 1);

namespace Phocate;


class BindTokenParser extends TokenParser
{
    /** @var TokenParser */
    private $from;
    /** @var callable */
    private $through;

    public function __construct(TokenParser $from, callable $through)
    {
        $this->from = $from;
        $this->through = $through;
    }

    public function parse(Tokens $tokens): ?TokenResult
    {
        $result = $this->from->parse($tokens);
        if ($result != null) {
            $through = $this->through;
            return $through($result->token)->parse($result->tokens);
        } else {
            return null;
        }
    }
}