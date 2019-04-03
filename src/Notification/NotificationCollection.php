<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\Notification;

/**
 * Breadcrumb class
 *
 * @author  Romain Cottar
 */
class NotificationCollection implements \Iterator, \Countable
{
    /** @var int $index Current index item. */
    private $index = 0;

    /** @var int $count Number of notification */
    private $count = 0;

    /** @var NotificationInterface[] $collection */
    private $collection = [];

    /**
     * Add item.
     *
     * @param  NotificationInterface $item
     * @return self
     */
    public function add(NotificationInterface $item): self
    {
        $this->collection[$this->count] = $item;

        $this->count++;

        return $this;
    }

    /**
     * Current iterator method.
     *
     * @return NotificationInterface
     */
    public function current(): NotificationInterface
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
