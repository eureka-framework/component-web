<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Menu;

class MenuItem
{
    private string $name = '';
    private string $icon = '';
    private string $uri = '';
    private ?Menu $submenu = null;
    private bool $isActive = false;
    private bool $isDivider = false;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getSubmenu(): ?Menu
    {
        return $this->submenu;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function isDivider(): bool
    {
        return $this->isDivider;
    }

    public function hasIcon(): bool
    {
        return $this->getIcon() !== '';
    }

    public function hasSubmenu(): bool
    {
        return $this->submenu instanceof Menu && $this->submenu->count() > 0;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function setIsDivider(bool $isDivider): self
    {
        $this->isDivider = $isDivider;

        return $this;
    }

    public function setSubmenu(Menu $submenu): self
    {
        $this->submenu = $submenu;

        return $this;
    }
}
