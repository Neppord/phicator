<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data\UseData;


class UsagesIterator implements \Iterator
{

    /** @var UseDataList */
    private $usages;

    public function __construct(UseDataList $usage)
    {
        $this->usages = $usage;
    }

    public function current()
    {
        if ($this->usages instanceof ConsUseDataList) {
            return $this->usages->getHead();
        } else {
            return null;
        }
    }

    public function next()
    {
        if ($this->usages instanceof ConsUseDataList) {
            $this->usages = $this->usages->getTail();
        }
    }

    public function key()
    {
        return null;
    }

    public function valid()
    {
        return $this->usages instanceof ConsUseDataList;
    }

    public function rewind()
    {
        return null;
    }
}