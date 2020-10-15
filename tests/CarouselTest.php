<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests;

use Eureka\Component\Web\Carousel\Carousel;
use Eureka\Component\Web\Carousel\CarouselItem;
use PHPUnit\Framework\TestCase;

/**
 * Class CarouselTest
 *
 * @author Romain Cottard
 */
class CarouselTest extends TestCase
{
    /**
     * @return void
     */
    public function testICanInitializeCarousel(): void
    {
        $carousel = new Carousel();

        $this->assertInstanceOf(Carousel::class, $carousel);
    }

    /**
     * @return void
     */
    public function testICanPushAndPopItemToCarousel(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        $item = $carousel->pop();

        $this->assertEquals('item 2', $item->getTitle());
    }

    /**
     * @return void
     */
    public function testICanIterateOnCarouselInstance(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        foreach ($carousel as $index => $item) {
            $this->assertEquals('item ' . ($index + 1), $item->getTitle());
        }
    }

    /**
     * @return void
     */
    public function testICanCountItemInCarousel(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        $this->assertCount(2, $carousel);
        $this->assertEquals(2, count($carousel));
    }

    /**
     * @return void
     */
    public function testICanCheckIfItIsTheFirstItemDuringTheIterationOnCarousel(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        $carousel->rewind();

        $this->assertTrue($carousel->isFirst());
    }

    /**
     * @return void
     */
    public function testICanCheckIfItIsTheLastItemDuringTheIterationOnCarousel(): void
    {
        $carousel = new Carousel();
        $carousel->push(new CarouselItem('item 1'));
        $carousel->push(new CarouselItem('item 2'));

        $carousel->rewind();
        $carousel->next();

        $this->assertTrue($carousel->isLast());
    }

    /**
     * @return void
     */
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

        $this->assertSame('title', $item->getTitle());
        $this->assertSame('sub title', $item->getSubTitle());
        $this->assertSame('image', $item->getImage());
        $this->assertSame('uri', $item->getLinkUri());
        $this->assertSame('uri title', $item->getLinkTitle());
        $this->assertTrue($item->isActive());
    }
}
