<?php
declare(strict_types = 1);

namespace Phocate;


use Phocate\Token\Either;

class ClassObject implements Either
{
    /** @var string */
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

}