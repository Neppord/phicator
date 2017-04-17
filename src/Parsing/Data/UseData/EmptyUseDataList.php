<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data\UseData;


class EmptyUseDataList implements UseDataList
{

    public function get(string $name): MaybeUseData
    {
        return new NothingUseData();
    }

    public function append(UseDataList $other): UseDataList
    {
        return $other;
    }

    public function toArray()
    {
        return [];
    }

    public function getIterator()
    {
        return new UsagesIterator($this);
    }
}