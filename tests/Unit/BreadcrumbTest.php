<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests\Unit;

use Eureka\Component\Web\Breadcrumb\Breadcrumb;
use Eureka\Component\Web\Breadcrumb\BreadcrumbItem;
use PHPUnit\Framework\TestCase;

class BreadcrumbTest extends TestCase
{
    public function testICanPushAndPopItemToBreadcrumb(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        $item = $breadcrumb->pop();

        self::assertSame('item 2', $item->getName());
    }

    public function testICanIterateOnBreadcrumbInstance(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        foreach ($breadcrumb as $index => $item) {
            /** @var BreadcrumbItem $item */
            self::assertSame('item ' . ($index + 1), $item->getName());
        }
    }

    public function testICanCountItemInBreadcrumb(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        self::assertCount(2, $breadcrumb);
    }

    public function testICanCheckIfItIsTheFirstItemDuringTheIterationOnBreadcrumb(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        $breadcrumb->rewind();

        self::assertTrue($breadcrumb->isFirst());
    }

    public function testICanCheckIfItIsTheLastItemDuringTheIterationOnBreadcrumb(): void
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->push(new BreadcrumbItem('item 1'));
        $breadcrumb->push(new BreadcrumbItem('item 2'));

        $breadcrumb->rewind();
        $breadcrumb->next();

        self::assertTrue($breadcrumb->isLast());
    }

    public function testICanSetAndRetrieveAllInformationOnItem(): void
    {
        $item = (new BreadcrumbItem('item 1'))
            ->setIcon('icon')
            ->setUri('uri')
            ->setIsActive(true)
        ;

        self::assertSame('item 1', $item->getName());
        self::assertSame('icon', $item->getIcon());
        self::assertSame('uri', $item->getUri());
        self::assertTrue($item->isActive());
    }
}
