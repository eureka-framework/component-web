<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Breadcrumb;

use Eureka\Component\Web\Collection\AbstractCollection;

/**
 * Breadcrumb class
 *
 * @author  Romain Cottard
 */
class Breadcrumb extends AbstractCollection
{
    /**
     * Add item.
     *
     * @param BreadcrumbItem $item
     * @return $this
     */
    public function push(BreadcrumbItem $item): self
    {
        $this->pushItem($item);

        return $this;
    }

    /**
     * @return BreadcrumbItem
     */
    public function pop(): BreadcrumbItem
    {
        /** @var BreadcrumbItem $item */
        $item = $this->popItem();

        return $item;
    }
}
