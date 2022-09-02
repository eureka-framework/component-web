<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Notification;

use Eureka\Component\Web\Collection\AbstractCollection;

/**
 * Breadcrumb class
 *
 * @author  Romain Cottar
 */
class NotificationCollection extends AbstractCollection
{
    /**
     * Add item.
     *
     * @param NotificationInterface $item
     * @return $this
     */
    public function push(NotificationInterface $item): self
    {
        $this->pushItem($item);

        return $this;
    }

    /**
     * @return NotificationInterface
     */
    public function pop(): NotificationInterface
    {
        /** @var NotificationInterface $item */
        $item = $this->popItem();

        return $item;
    }
}
