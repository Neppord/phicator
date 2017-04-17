<?php
declare(strict_types=1);

namespace Phocate\Parsing\Data;


class UsagesIterator implements \Iterator
{

    /** @var Usages */
    private $usages;

    public function __construct(Usages $usage)
    {
        $this->usages = $usage;
    }

    public function current()
    {
        if ($this->usages instanceof ConsUsages) {
            return $this->usages->getHead();
        } else {
            return null;
        }
    }

    public function next()
    {
        if ($this->usages instanceof ConsUsages) {
            $this->usages = $this->usages->getTail();
        }
    }

    public function key()
    {
        return null;
    }

    public function valid()
    {
        return $this->usages instanceof ConsUsages;
    }

    public function rewind()
    {
        return null;
    }
}