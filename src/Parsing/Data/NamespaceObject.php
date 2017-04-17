<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data;


use Phocate\Parsing\Data\UseData\EmptyUseDataList;
use Phocate\Parsing\Data\UseData\UseDataList;
use Phocate\Parsing\Either;

class NamespaceObject implements Either
{
    /** @var String */
    public $name = '';

    /** @var ClassObject[] */
    public $classes = [];
    /** @var UseDataList */
    public $usages;
    public $functions = [];
    public $variables = [];

    public function __construct(
        string $name
    ) {
        $this->name = $name;
        $this->usages = new EmptyUseDataList();
    }
}