<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests;

use Eureka\Component\Web\Menu\Menu;
use Eureka\Component\Web\Menu\MenuItem;
use PHPUnit\Framework\TestCase;

/**
 * Class MenuTest
 *
 * @author Romain Cottard
 */
class MenuTest extends TestCase
{
    /**
     * @return void
     */
    public function testICanInitializeMenu(): void
    {
        $menu = new Menu();

        $this->assertInstanceOf(Menu::class, $menu);
    }

    /**
     * @return void
     */
    public function testICanPushAndGetItemToMenu(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        $item = $menu->get('item 2');

        $this->assertEquals('item 2', $item->getName());
    }

    /**
     * @return void
     */
    public function testICanIterateOnMenuInstance(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        foreach ($menu as $index => $item) {
            $this->assertEquals('item ' . ($index + 1), $item->getName());
        }
    }

    /**
     * @return void
     */
    public function testICanCountItemInMenu(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        $this->assertCount(2, $menu);
        $this->assertEquals(2, count($menu));
    }

    /**
     * @return void
     */
    public function testICanCheckIfItIsTheFirstItemDuringTheIterationOnMenu(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        $menu->rewind();

        $this->assertTrue($menu->isFirst());
    }

    /**
     * @return void
     */
    public function testICanCheckIfItIsTheLastItemDuringTheIterationOnMenu(): void
    {
        $menu = new Menu();
        $menu->push(new MenuItem('item 1'));
        $menu->push(new MenuItem('item 2'));

        $menu->rewind();
        $menu->next();

        $this->assertTrue($menu->isLast());
    }

    /**
     * @return void
     */
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

        $this->assertSame('item 1', $item->getName());
        $this->assertSame('icon', $item->getIcon());
        $this->assertSame('uri', $item->getUri());
        $this->assertInstanceOf(Menu::class, $item->getSubmenu());
        $this->assertTrue($item->isActive());
        $this->assertTrue($item->isDivider());
        $this->assertTrue($item->hasIcon());
        $this->assertTrue($item->hasSubmenu());
    }
}
