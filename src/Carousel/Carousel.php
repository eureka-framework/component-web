<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Carousel;

use Eureka\Component\Web\Collection\AbstractCollection;

/**
 * Breadcrumb class
 *
 * @author  Romain Cottard
 */
class Carousel extends AbstractCollection
{
    /**
     * Add item.
     *
     * @param CarouselItem $item
     * @return $this
     */
    public function push(CarouselItem $item): self
    {
        $this->pushItem($item);

        return $this;
    }

    /**
     * @return CarouselItem
     */
    public function pop(): CarouselItem
    {
        /** @var CarouselItem $item */
        $item = $this->popItem();

        return $item;
    }
}
