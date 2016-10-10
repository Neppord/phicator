<?php
declare(strict_types=1);

namespace Phocate\Token;


class Tokens
{
    /** @var array */
    private $array;
    /** @var int */
    private $length;
    /** @var int */
    private $index;

    public function __construct(
        array $array,
        int $length,
        int $index = 0
    ) {
        while ($index < $length && !is_array($array[$index])) {
            $index += 1;
        }
        $this->array = $array;
        $this->length = $length;
        $this->index = $index;
    }

    public function nil(): bool
    {
        return $this->index >= $this->length;
    }

    public function head(): Token
    {
        return Token::fromArray($this->array[$this->index]);
    }

    public function tail(): Tokens
    {
        return new self($this->array, $this->length, $this->index + 1);
    }
}