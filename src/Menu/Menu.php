<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Menu;

use Eureka\Component\Web\Collection\AbstractCollection;

class Menu extends AbstractCollection
{
    public function push(MenuItem $item): self
    {
        $this->pushItem($item);

        return $this;
    }

    public function get(string $name): ?MenuItem
    {
        /** @var MenuItem $item */
        $item = $this->getItem($name);

        return $item;
    }
}
