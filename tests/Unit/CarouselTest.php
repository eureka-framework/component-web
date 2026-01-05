<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests\Unit;

use Eureka\Component\Web\Carousel\Carousel;
use Eureka\Component\Web\Carousel\CarouselItem;
use PHPUnit\Framework\TestCase;

class CarouselTest extends TestCase
{
    public function testICanPushAndPopItemToCarousel(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        $item = $carousel->pop();

        self::assertSame('item 2', $item->getTitle());
    }

    public function testICanIterateOnCarouselInstance(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        foreach ($carousel as $index => $item) {
            /** @var CarouselItem $item */
            self::assertSame('item ' . ($index + 1), $item->getTitle());
        }
    }

    public function testICanCountItemInCarousel(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        self::assertCount(2, $carousel);
    }

    public function testICanCheckIfItIsTheFirstItemDuringTheIterationOnCarousel(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        $carousel->rewind();

        self::assertTrue($carousel->isFirst());
    }

    public function testICanCheckIfItIsTheLastItemDuringTheIterationOnCarousel(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        $carousel->rewind();
        $carousel->next();

        self::assertTrue($carousel->isLast());
    }

    public function testICanSetAndRetrieveAllInformationOnItem(): void
    {
        $item = (new CarouselItem(''))
            ->setImage('image')
            ->setLinkUri('uri')
            ->setLinkTitle('uri title')
            ->setTitle('title')
            ->setSubTitle('sub title')
            ->setIsActive(true)
        ;

        self::assertSame('title', $item->getTitle());
        self::assertSame('sub title', $item->getSubTitle());
        self::assertSame('image', $item->getImage());
        self::assertSame('uri', $item->getLinkUri());
        self::assertSame('uri title', $item->getLinkTitle());
        self::assertTrue($item->isActive());
    }
}
