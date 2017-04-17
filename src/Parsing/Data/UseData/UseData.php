<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data\UseData;


use Phocate\Parsing\Either;

class UseData implements Either, MaybeUseData
{

    /** @var string */
    public $FQN;
    /** @var string */
    public $name;

    public function __construct(string $FQN, string $as)
    {
        $this->FQN = $FQN;
        $this->name = $as;
    }
}