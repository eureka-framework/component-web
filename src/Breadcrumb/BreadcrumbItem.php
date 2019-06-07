<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\Breadcrumb;

/**
 * Class to set breadcrumb item.
 *
 * @author  Romain Cottard
 */
class BreadcrumbItem
{
    /** @var string $name Item name */
    private $name = '';

    /** @var string $icon Item icon */
    private $icon = '';

    /** @var string $uri Item Uri */
    private $uri = '';

    /** @var bool $isActive Item is active ? */
    private $isActive = false;

    /**
     * BreadcrumbItem constructor.
     *
     * @param $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Get Uri
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
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
     * Set name
     *
     * @param  string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set icon.
     *
     * @param  string $icon
     * @return $this
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set uri
     *
     * @param  string $uri
     * @return $this
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;

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
