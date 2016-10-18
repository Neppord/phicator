<?php


namespace Phocate\Parsing\Data;


interface Usages
{
    public function toArray();
    public function get(string $name): MaybeUsage;
    public function append(Usages $other): Usages;
}