<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests;

use Eureka\Component\Web\Breadcrumb\Breadcrumb;
use Eureka\Component\Web\Breadcrumb\BreadcrumbItem;
use PHPUnit\Framework\TestCase;

/**
 * Class BreadcrumbTest
 *
 * @author Romain Cottard
 */
class BreadcrumbTest extends TestCase
{
    /**
     * @return void
     */
    public function testICanInitializeBreadcrumb(): void
    {
        $breadcrumb = new Breadcrumb();

        $this->assertInstanceOf(Breadcrumb::class, $breadcrumb);
    }

    /**
     * @return void
     */
    public function testICanPushAndPopItemToBreadcrumb(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        $item = $breadcrumb->pop();

        $this->assertEquals('item 2', $item->getName());
    }

    /**
     * @return void
     */
    public function testICanIterateOnBreadcrumbInstance(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        foreach ($breadcrumb as $index => $item) {
            $this->assertEquals('item ' . ($index + 1), $item->getName());
        }
    }

    /**
     * @return void
     */
    public function testICanCountItemInBreadcrumb(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        $this->assertCount(2, $breadcrumb);
        $this->assertEquals(2, count($breadcrumb));
    }

    /**
     * @return void
     */
    public function testICanCheckIfItIsTheFirstItemDuringTheIterationOnBreadcrumb(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        $breadcrumb->rewind();

        $this->assertTrue($breadcrumb->isFirst());
    }

    /**
     * @return void
     */
    public function testICanCheckIfItIsTheLastItemDuringTheIterationOnBreadcrumb(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        $breadcrumb->rewind();
        $breadcrumb->next();

        $this->assertTrue($breadcrumb->isLast());
    }

    /**
     * @return void
     */
    public function testICanSetAndRetrieveAllInformationOnItem(): void
    {
        $item = (new BreadcrumbItem('item 1'))
            ->setIcon('icon')
            ->setUri('uri')
            ->setIsActive(true)
        ;

        $this->assertSame('item 1', $item->getName());
        $this->assertSame('icon', $item->getIcon());
        $this->assertSame('uri', $item->getUri());
        $this->assertTrue($item->isActive());

    }
}
