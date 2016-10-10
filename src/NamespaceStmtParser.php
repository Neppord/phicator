<?php
declare(strict_types = 1);

namespace Phocate;


class NamespaceStmtParser
{
    /** @var TokensParser */
    private $whitespace_p;
    /** @var TokensParser */
    private $namespace_p;
    /** @var TokensParser */
    private $ns_seperator_p;
    /** @var TokensParser */
    private $string_p;
    /** @var TokensParser */
    private $inner;

    public function __construct()
    {
        $this->whitespace_p = new LiftTokenToMany(
            new TokenTypeParser(T_WHITESPACE)
        );
        $this->namespace_p = new LiftTokenToMany(
            new TokenTypeParser(T_NAMESPACE)
        );
        $this->ns_seperator_p = new LiftTokenToMany(
            new TokenTypeParser(T_NS_SEPARATOR)
        );
        $this->string_p = new LiftTokenToMany(
            new TokenTypeParser(T_STRING)
        );
        $this->inner = $this->namespace_p->bind([$this, 'bind_namespace']);
    }

    public function bind_namespace(array $tokens): TokensParser
    {
        return $this->whitespace_p->bind([$this, 'bind_whitespace']);
    }

    public function bind_whitespace(array $tokens): TokensParser
    {
        return new SepByTokenParser($this->string_p, $this->ns_seperator_p);
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
