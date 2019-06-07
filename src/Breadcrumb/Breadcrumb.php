<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\Breadcrumb;

/**
 * Breadcrumb class
 *
 * @author  Romain Cottard
 */
class Breadcrumb implements \Iterator, \Countable
{
    /** @var int $index Current index key. */
    private $index = 0;

    /** @var int $count Number of element in breadcrumb */
    private $count = 0;

    /** @var CarouselItem[] $collection */
    private $collection = [];

    /**
     * Add item.
     *
     * @param CarouselItem $item
     * @return $this
     */
    public function add(CarouselItem $item): self
    {
        $this->collection[$this->count] = $item;

        $this->count++;

        return $this;
    }

    /**
     * Check if is the last element of breadcrumb.
     *
     * @return bool
     */
    public function isLast(): bool
    {
        return ($this->index === ($this->count - 1));
    }

    /**
     * Check if is the first element of breadcrumb.
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
     * @return CarouselItem
     */
    public function current(): CarouselItem
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
