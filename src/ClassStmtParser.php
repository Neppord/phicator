<?php
declare(strict_types = 1);

namespace Phocate;


use Phocate\Token\Token;
use Phocate\Token\Tokens;
use Phocate\Token\TokensParser;
use Phocate\Token\TokenTypeParser;

class ClassStmtParser extends StringParser
{

    /** @var TokensParser */
    private $inner;

    public function __construct()
    {
        $this->inner = (new TokenTypeParser(T_CLASS))
            ->before(new TokenTypeParser(T_WHITESPACE))
            ->before(new TokenTypeParser(T_STRING));
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
            return new StringResult(implode('', $strings), $result->tokens);
        }
    }
}