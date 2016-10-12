<?php
declare(strict_types = 1);

namespace Phocate\Statement;

use Phocate\StringParser;
use Phocate\StringResult;
use Phocate\Token\Token;
use Phocate\Token\Tokens;
use Phocate\Token\TokensParser;
use Phocate\Token\TokenTypeParser;

class NamespaceStmtParser extends StringParser
{
    /** @var TokensParser */
    private $inner;

    public function __construct()
    {
        $this->inner = (new TokenTypeParser(T_NAMESPACE))
            ->before(new TokenTypeParser(T_WHITESPACE))
            ->before(
                (new TokenTypeParser(T_STRING))
                    ->sepBy(new TokenTypeParser(T_NS_SEPARATOR))
            );
    }

    public function parse(Tokens $tokens): StringResult
    {
        return $this->inner
            ->parse($tokens)
            ->mapToStringResult(function (array $tokens){
                $strings = array_map(function (Token $token) {
                    return $token->contents;
                },$tokens);
                return implode('\\', $strings);
            });
    }
}
