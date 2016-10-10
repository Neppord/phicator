<?php
declare(strict_types = 1);

namespace Phocate\File;


use Phocate\Token\Tokens;

class PhpFile
{
    /** @var string */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getTokens(): Tokens
    {
        $content = file_get_contents($this->path);
        $tokens = token_get_all($content);
        return new Tokens($tokens, count($tokens));
    }

    public function getPath()
    {
        return $this->path;
    }

}