<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Collection;

use Eureka\Component\Web\Breadcrumb\BreadcrumbItem;
use Eureka\Component\Web\Carousel\CarouselItem;
use Eureka\Component\Web\Menu\MenuItem;
use Eureka\Component\Web\Notification\NotificationInterface;

/**
 * @implements \Iterator<int, BreadcrumbItem|CarouselItem|MenuItem|NotificationInterface>
 */
class AbstractCollection implements \Iterator, \Countable
{
    private int $index = 0;
    /** @var int<0, max> $count */
    private int $count = 0;

    /** @var array<BreadcrumbItem|CarouselItem|MenuItem|NotificationInterface> $collection */
    private array $collection = [];

    /** @var int[] $names */
    private array $names = [];

    public function isLast(): bool
    {
        return ($this->index === ($this->count - 1));
    }

    public function isFirst(): bool
    {
        return ($this->index === 0);
    }

    public function current(): BreadcrumbItem|CarouselItem|MenuItem|NotificationInterface
    {
        return $this->collection[$this->index];
    }

    public function key(): int
    {
        return $this->index;
    }

    public function next(): void
    {
        $this->index++;
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function valid(): bool
    {
        return ($this->index < $this->count);
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return $this->count;
    }

    protected function pushItem(BreadcrumbItem|CarouselItem|MenuItem|NotificationInterface $item): self
    {
        /** @var string $itemName */
        $itemName = \method_exists($item, 'getName') ? $item->getName() : (string) $this->count();
        $this->collection[$this->count] = $item;
        $this->names[$itemName]  = $this->count;

        $this->count++;

        return $this;
    }

    protected function popItem(): BreadcrumbItem|CarouselItem|MenuItem|NotificationInterface
    {
        $last = \array_pop($this->collection);

        if ($last === null) {
            throw new \LengthException('Cannot pop from an empty collection.');
        }
        if ($this->count > 0) {
            $this->count--;
        }

        $this->rewind();

        return $last;
    }

    protected function getItem(string $name): BreadcrumbItem|CarouselItem|MenuItem|NotificationInterface|null
    {
        if (!isset($this->names[$name])) {
            return null;
        }

        $index = $this->names[$name];

        return $this->collection[$index];
    }
}
