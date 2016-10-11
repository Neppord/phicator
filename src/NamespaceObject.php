<?php
declare(strict_types = 1);

namespace Phocate;


class NamespaceObject
{
    /** @var String */
    public $name = '';

    /** @var ClassObject[] */
    public $classes = [];
    public $functions = [];
    public $variables = [];
}