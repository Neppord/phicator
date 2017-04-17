<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data\UseData;


class ConsUseDataList implements UseDataList
{
    /** @var UseData */
    private $head;
    /** @var UseDataList */
    private $tail;

    public function __construct(UseData $head, UseDataList $tail)
    {
        $this->head = $head;
        $this->tail = $tail;
    }

    public function get(string $name): MaybeUseData
    {
        if ($this->head->name === $name) {
            return $this->head;
        } else {
            return $this->tail->get($name);
        }
    }

    public function append(UseDataList $other): UseDataList
    {
        return new ConsUseDataList(
            $this->head,
            $this->tail->append($other)
        );
    }

    public function toArray()
    {
        return array_merge(
            [$this->head],
            $this->tail->toArray()
        );
    }

    public function getIterator()
    {
        return new UsagesIterator($this);
    }

    public function getHead(): UseData
    {
        return $this->head;
    }

    public function getTail(): UseDataList
    {
        return $this->tail;
    }
}