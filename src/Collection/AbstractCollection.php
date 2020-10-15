<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Collection;

/**
 * Class AbstractCollection
 *
 * @author Romain Cottard
 */
class AbstractCollection implements \Iterator, \Countable
{
    /** @var int $index Current index key. */
    private int $index = 0;

    /** @var int $count Number of element in breadcrumb */
    private int $count = 0;

    /** @var array $collection */
    private array $collection = [];

    /** @var int[] $names */
    private array $names = [];


    /**
     * Check if is the last element of collection.
     *
     * @return bool
     */
    public function isLast(): bool
    {
        return ($this->index === ($this->count - 1));
    }

    /**
     * Check if is the first element of collection.
     *
     * @return bool
     */
    public function isFirst(): bool
    {
        return ($this->index === 0);
    }

    /**
     * Current iterator method.
     *
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->index];
    }

    /**
     * Key iterator method.
     *
     * @return int
     */
    public function key(): int
    {
        return $this->index;
    }

    /**
     * Next iterator method.
     *
     * @return void
     */
    public function next(): void
    {
        $this->index++;
    }

    /**
     * Rewind iterator method.
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * Valid iterator method.
     *
     * @return bool
     */
    public function valid(): bool
    {
        return ($this->index < $this->count);
    }

    /**
     * Count countable method.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * @param $item
     * @return $this
     */
    protected function pushItem($item)
    {
        $itemName = method_exists($item, 'getName') ? $item->getName() : (string) $this->count();
        $this->collection[$this->count] = $item;
        $this->names[$itemName]  = $this->count;

        $this->count++;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function popItem()
    {
        $last = array_pop($this->collection);
        $this->count--;
        $this->rewind();

        return $last;
    }

    /**
     * Get menu item by name.
     *
     * @param  string $name
     * @return mixed
     */
    protected function getItem(string $name)
    {
        if (!isset($this->names[$name])) {
            return null;
        }

        $index = $this->names[$name];

        return $this->collection[$index];
    }
}
