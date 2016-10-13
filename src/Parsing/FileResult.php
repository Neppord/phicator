<?php
declare(strict_types = 1);

namespace Phocate\Parsing;

use Phocate\Parsing\Data\FileObject;
use Phocate\Parsing\Token\Tokens;

class FileResult
{
    /** @var FileObject */
    public $file;
    /** @var Tokens */
    public $tokens;

    public function __construct(FileObject $file, Tokens $tokens)
    {
        $this->file = $file;
        $this->tokens = $tokens;
    }

}