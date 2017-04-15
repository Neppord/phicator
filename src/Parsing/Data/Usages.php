<?php


namespace Phocate\Parsing\Data;


interface Usages extends \IteratorAggregate
{
    public function toArray();
    public function get(string $name): MaybeUsage;
    public function append(Usages $other): Usages;
}