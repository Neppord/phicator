<?php
namespace Phocate;

class BeforParser extends Parser
{
    /** @var Parser*/
    private $first;
    /** @var Parser*/
    private $other;

    /**
     * BeforParser constructor.
     * @param $first
     * @param $other
     * @internal param Parser $this
     */
    public function __construct(Parser $first, Parser $other)
    {
        $this->first = $first;
        $this->other = $other;
    }

    public function parse(Tokens $tokens): ParseResult
    {
        $result = $this->first->parse($tokens);
        if ($result->succeeded()) {
            return $this->other->parse($result->tokens());
        } else {
            return $result;
        }
    }
}
