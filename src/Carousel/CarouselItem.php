<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\Carousel;

/**
 * Class to set carousel item.
 *
 * @author  Romain Cottard
 */
class CarouselItem
{
    /** @var string $title Item title */
    private $title = '';

    /** @var string $subTitle Item subtitle */
    private $subTitle = '';

    /** @var string $image Item image */
    private $image = '';

    /** @var string $linkTitle Item link title */
    private $linkTitle = '';

    /** @var string $linkUri Item link Uri */
    private $linkUri = '';

    /** @var bool $isActive Item is active ? */
    private $isActive = false;

    /**
     * CarouselItem constructor.
     *
     * @param string $title
     */
    public function __construct(string $title = '')
    {
        $this->setTitle($title);
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get sub title
     *
     * @return string
     */
    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Get link title
     *
     * @return string
     */
    public function getLinkTitle(): string
    {
        return $this->linkTitle;
    }

    /**
     * Get link Uri
     *
     * @return string
     */
    public function getLinkUri(): string
    {
        return $this->linkUri;
    }

    /**
     * Get is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Set Title
     *
     * @param string $title
     * @return CarouselItem
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set subtitle
     *
     * @param string $subTitle
     * @return CarouselItem
     */
    public function setSubTitle(string $subTitle): self
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * Set image.
     *
     * @param  string $image
     * @return $this
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @param string $linkTitle
     * @return CarouselItem
     */
    public function setLinkTitle(string $linkTitle): self
    {
        $this->linkTitle = $linkTitle;

        return $this;
    }

    /**
     * @param string $linkUri
     * @return CarouselItem
     */
    public function setLinkUri(string $linkUri): self
    {
        $this->linkUri = $linkUri;

        return $this;
    }

    /**
     * Set is Active
     *
     * @param  bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
