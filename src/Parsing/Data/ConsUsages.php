<?php
declare(strict_types = 1);

namespace Phocate\Parsing\Data;


class ConsUsages implements Usages
{
    /** @var Usage */
    private $head;
    /** @var Usages */
    private $tail;

    public function __construct(Usage $head, Usages $tail)
    {
        $this->head = $head;
        $this->tail = $tail;
    }

    public function get(string $name): MaybeUsage
    {
        if ($this->head->name === $name) {
            return $this->head;
        } else {
            return $this->tail->get($name);
        }
    }

    public function append(Usages $other): Usages
    {
        return new ConsUsages(
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
        return new UsageIterator($this);
    }

    public function getHead(): Usage
    {
        return $this->head;
    }

    public function getTail(): Usages
    {
        return $this->tail;
    }
}