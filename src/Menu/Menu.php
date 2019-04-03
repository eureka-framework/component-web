<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\Menu;

/**
 * Menu class
 *
 * @author  Romain Cottard
 */
class Menu implements \Iterator, \Countable
{
    /** @var int $index Current index menu. */
    private $index = 0;

    /** @var int $count Number of item in collection */
    private $count = 0;

    /** @var int[] $names */
    private $names = [];

    /** @var MenuItem[] $collection */
    private $collection = [];

    /**
     * Add item.
     *
     * @param  MenuItem $item
     * @return self
     */
    public function add(MenuItem $item): self
    {
        $this->collection[$this->count] = $item;
        $this->names[$item->getName()]  = $this->count;

        $this->count++;

        return $this;
    }

    /**
     * Get menu item by name.
     *
     * @param  string $name
     * @return MenuItem
     */
    public function getItem(string $name): MenuItem
    {
        $index = $this->names[$name];

        return $this->collection[$index];
    }

    /**
     * Current iterator method.
     *
     * @return MenuItem
     */
    public function current(): MenuItem
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
}
