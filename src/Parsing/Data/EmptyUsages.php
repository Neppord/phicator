<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data;


class EmptyUsages implements Usages
{

    public function get(string $name): MaybeUsage
    {
        return new NothingUsage();
    }

    public function append(Usages $other): Usages
    {
        return $other;
    }

    public function toArray()
    {
        return [];
    }
}