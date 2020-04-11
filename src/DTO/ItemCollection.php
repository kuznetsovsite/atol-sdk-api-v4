<?php

namespace SaveTime\AtolV4\DTO;

use ArrayAccess;
use Iterator;

class ItemCollection implements Iterator, ArrayAccess
{
    /** @var Item[] */
    private $items = [];
    private $pointer = 0;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function addItem(Item $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    public function current(): ?Item
    {
        return $this->items[$this->pointer];
    }

    public function flush(): self
    {
        $this->items = [];
        $this->pointer = 0;
        return $this;
    }

    public function getSum(): float
    {
        $sum = 0;
        foreach ($this->items as $item) {
            // переводим в копейки
            $sum += $item->getPositionSum() * 100;
        }
        // переводим в рубли
        return (float) $sum / 100;
    }

    public function isEmpty()
    {
        return empty($this->items);
    }

    public function key(): int
    {
        return $this->pointer;
    }

    public function next(): void
    {
        ++$this->pointer;
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $item)
    {
        if (!$offset) {
            $offset = $this->pointer++;
        }
        $this->setItem($offset, $item);
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function rewind(): void
    {
        $this->pointer = 0;
    }

    public function setItem(int $offset, Item $item)
    {
        $this->items[$offset] = $item;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->pointer]);
    }


}
