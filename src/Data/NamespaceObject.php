<?php
declare(strict_types = 1);

namespace Phocate\Data;


use Phocate\Token\Either;

class NamespaceObject implements Either
{
    /** @var String */
    public $name = '';

    /** @var ClassObject[] */
    public $classes = [];
    /** @var UseObject[] */
    public $usages = [];
    public $functions = [];
    public $variables = [];

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }
}