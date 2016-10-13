<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Token;


use Phocate\Parsing\EitherParser;
use Phocate\Parsing\StringParser;

abstract class TokensParser
{
    abstract public function parse(Tokens $tokens): TokensResult;
    public function bind(callable $closure): TokensParser
    {
        return new BindTokensParser($this, $closure);
    }

    public function bindEither(callable $closure): EitherParser
    {
        return new BindTokensParserToEitherParser($this, $closure);
    }

    public function before(TokensParser $parser): TokensParser
    {
        /** @noinspection PhpUnusedParameterInspection */
        return $this->bind(function (array $tokens) use ($parser){
            return $parser;
        });
    }

    public function sepBy(TokensParser $separator): TokensParser
    {
        return new SepByTokenParser($this, $separator);
    }

    public function mapToStringParser(callable $closure): StringParser
    {
        return new MapTokenParserToStringParser($this, $closure);
    }


    public function mapToEitherParser(callable $closure): EitherParser
    {
        return new MapTokenParserToEither($this, $closure);
    }
}