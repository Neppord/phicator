<?php
declare(strict_types=1);
namespace Phocate;

class OrParser extends Parser
{
    /** @var Parser */
    private $first;
    /** @var Parser */
    private $other;

    /**
     * OrParser constructor.
     * @param Parser $first
     * @param Parser $other
     */
    public function __construct($first, $other)
    {
        $this->first = $first;
        $this->other = $other;
    }

    public function parse(Tokens $tokens): ParseResult
    {
        $result = $this->first->parse($tokens);
        if ($result->succeeded()) {
            return $result;
        } else {
            return $this->other->parse($tokens);
        }
    }
}
