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

class NotificationCollection extends AbstractCollection
{
    public function push(NotificationInterface $item): self
    {
        $this->pushItem($item);

        return $this;
    }

    public function pop(): NotificationInterface
    {
        /** @var NotificationInterface $item */
        $item = $this->popItem();

        return $item;
    }
}
