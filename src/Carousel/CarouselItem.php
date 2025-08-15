<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Carousel;

/**
 * Class to set carousel item.
 *
 * @author  Romain Cottard
 */
class CarouselItem
{
    private string $title = '';
    private string $subTitle = '';
    private string $image = '';
    private string $linkTitle = '';
    private string $linkUri = '';
    private bool $isActive = false;

    public function __construct(string $title = '')
    {
        $this->setTitle($title);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getLinkTitle(): string
    {
        return $this->linkTitle;
    }

    public function getLinkUri(): string
    {
        return $this->linkUri;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setSubTitle(string $subTitle): self
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setLinkTitle(string $linkTitle): self
    {
        $this->linkTitle = $linkTitle;

        return $this;
    }

    public function setLinkUri(string $linkUri): self
    {
        $this->linkUri = $linkUri;

        return $this;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
