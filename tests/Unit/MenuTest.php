<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests\Unit;

use Eureka\Component\Web\Menu\Menu;
use Eureka\Component\Web\Menu\MenuItem;
use PHPUnit\Framework\TestCase;

class MenuTest extends TestCase
{
    public function testICanPushAndGetItemToMenu(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        $item = $menu->get('item 2');

        self::assertEquals('item 2', $item?->getName());
    }

    public function testICanIterateOnMenuInstance(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        foreach ($menu as $index => $item) {
            /** @var MenuItem $item */
            self::assertEquals('item ' . ($index + 1), $item->getName());
        }
    }

    public function testICanCountItemInMenu(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        self::assertCount(2, $menu);
    }

    public function testICanCheckIfItIsTheFirstItemDuringTheIterationOnMenu(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        $menu->rewind();

        self::assertTrue($menu->isFirst());
    }

    public function testICanCheckIfItIsTheLastItemDuringTheIterationOnMenu(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        $menu->rewind();
        $menu->next();

        self::assertTrue($menu->isLast());
    }

    public function testICanSetAndRetrieveAllInformationOnItem(): void
    {
        $item = (new MenuItem(''))
            ->setName('item 1')
            ->setIcon('icon')
            ->setUri('uri')
            ->setSubmenu((new Menu())->push(new MenuItem('sub item 1')))
            ->setIsDivider(true)
            ->setIsActive(true)
        ;

        self::assertSame('item 1', $item->getName());
        self::assertSame('icon', $item->getIcon());
        self::assertSame('uri', $item->getUri());
        self::assertInstanceOf(Menu::class, $item->getSubmenu());
        self::assertTrue($item->isActive());
        self::assertTrue($item->isDivider());
        self::assertTrue($item->hasIcon());
        self::assertTrue($item->hasSubmenu());
    }
}
