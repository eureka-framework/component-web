<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Menu;

/**
 * Class to set menu item.
 *
 * @author  Romain Cottard
 */
class MenuItem
{
    /** @var string $name Menu name */
    private string $name = '';

    /** @var string $icon Menu icon */
    private string $icon = '';

    /** @var string $uri Menu URI */
    private string $uri = '';

    /** @var Menu|null $submenu Sub menu. */
    private ?Menu $submenu = null;

    /** @var bool $isActive If is currently active */
    private bool $isActive = false;

    /** @var bool $isDivider If is divider */
    private bool $isDivider = false;

    /**
     * MenuItem constructor.
     *
     * @param string $name
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
     * Get submenu
     *
     * @return Menu|null
     */
    public function getSubmenu(): ?Menu
    {
        return $this->submenu;
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
     * Get is active.
     *
     * @return bool
     */
    public function isDivider(): bool
    {
        return $this->isDivider;
    }

    /**
     * If has submenu with elements.
     *
     * @return bool
     */
    public function hasIcon(): bool
    {
        return !empty($this->getIcon());
    }

    /**
     * If has submenu with elements.
     *
     * @return bool
     */
    public function hasSubmenu(): bool
    {
        return ($this->submenu instanceof Menu) && $this->submenu->count() > 0;
    }

    /**
     * Set name
     *
     * @param  string $name
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Set is divider
     *
     * @param  bool $isDivider
     * @return self
     */
    public function setIsDivider(bool $isDivider): self
    {
        $this->isDivider = $isDivider;

        return $this;
    }

    /**
     * Set submenu instance.
     *
     * @param  Menu $submenu
     * @return self
     */
    public function setSubmenu(Menu $submenu): self
    {
        $this->submenu = $submenu;

        return $this;
    }
}
