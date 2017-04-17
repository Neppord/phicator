<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data\UseData;


interface UseDataList extends \IteratorAggregate
{
    public function toArray();
    public function get(string $name): MaybeUseData;
    public function append(UseDataList $other): UseDataList;
}