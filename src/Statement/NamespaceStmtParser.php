<?php
declare(strict_types = 1);

namespace Phocate\Statement;

use Phocate\StringParser;
use Phocate\StringResult;
use Phocate\Token\Token;
use Phocate\Token\Tokens;
use Phocate\Token\Match;

class NamespaceStmtParser extends StringParser
{
    /** @var StringParser */
    private $inner;

    public function __construct()
    {
        $this->inner = (new Match(T_NAMESPACE))
            ->before(new Match(T_WHITESPACE))
            ->before(
                (new Match(T_STRING))->sepBy(new Match(T_NS_SEPARATOR))
            )->mapToStringParser(function (array $tokens){
                $strings = array_map(function (Token $token) {
                    return $token->contents;
                },$tokens);
                return implode('\\', $strings);
            });
    }

    public function parse(Tokens $tokens): StringResult
    {
        return $this->inner->parse($tokens);
    }
}
