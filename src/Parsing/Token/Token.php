<?php
declare(strict_types=1);

namespace Phocate\Parsing\Token;


class Token
{
    /** @var integer */
    public $type;
    /** @var string */
    public $contents;

    static function fromArray(array $array): Token {
        $token = new self();
        $token->type = $array[0];
        $token->contents = $array[1];
        return $token;
    }
}