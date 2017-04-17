<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data\UseData;


interface Usages extends \IteratorAggregate
{
    public function toArray();
    public function get(string $name): MaybeUsage;
    public function append(Usages $other): Usages;
}