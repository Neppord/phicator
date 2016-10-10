<?php
declare(strict_types=1);

namespace Phocate;


interface ParseResult
{
    public function succeeded(): bool;
    public function tokens(): Tokens;
}