<?php
declare(strict_types = 1);

namespace Phocate;


class NamespaceStmtParser
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

    public function parse(Tokens $tokens): ?StringResult
    {
        $result = $this->inner->parse($tokens);
        if ($result === null) {
            return null;
        } else {
            $strings = array_map(function (Token $token) {
                return $token->contents;
            },$result->result);
            return new StringResult(implode('\\', $strings), $result->tokens);
        }
    }
}
