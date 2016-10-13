<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data;


class FileObject
{
    /** @var string */
    public $path = '';
    /** @var NamespaceObject[] */
    public $namespaces = [];

}