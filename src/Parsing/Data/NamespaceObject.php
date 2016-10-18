<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data;


use Phocate\Parsing\Either;

class NamespaceObject implements Either
{
    /** @var String */
    public $name = '';

    /** @var ClassObject[] */
    public $classes = [];
    /** @var Usages */
    public $usages;
    public $functions = [];
    public $variables = [];

    public function __construct(
        string $name
    ) {
        $this->name = $name;
        $this->usages = new EmptyUsages();
    }
}