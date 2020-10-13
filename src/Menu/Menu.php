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

/**
 * Menu class
 *
 * @author  Romain Cottard
 */
class Menu extends AbstractCollection
{
    /**
     * Add item.
     *
     * @param  MenuItem $item
     * @return self
     */
    public function push(MenuItem $item): self
    {
        $this->pushItem($item);

        return $this;
    }

    /**
     * Get menu item by name.
     *
     * @param  string $name
     * @return MenuItem
     */
    public function get(string $name): MenuItem
    {
        return $this->getItem($name);
    }
}
