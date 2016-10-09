<?php
declare(strict_types=1);

namespace Phocate\File;


use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class Directory
{

    /** @var string */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return \Generator|PhpFile[]
     */
    public function getPhpFiles(): \Generator
    {
        $directory = new RecursiveDirectoryIterator($this->path);
        $iterator = new RecursiveIteratorIterator($directory);
        $php_files = new RegexIterator(
            $iterator,
            '/^.+\.php$/i',
            RecursiveRegexIterator::GET_MATCH
        );
        foreach($php_files as $match) {
            yield new PhpFile($match[0]);
        }
    }

}