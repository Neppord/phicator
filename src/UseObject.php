<?php
declare(strict_types = 1);

namespace Phocate;


use Phocate\Token\Either;

class UseObject implements Either
{

    /** @var string */
    private $FQN;
    /** @var string */
    private $as;

    public function __construct(string $FQN, string $as)
    {
        $this->FQN = $FQN;
        $this->as = $as;
    }
}