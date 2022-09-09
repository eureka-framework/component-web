<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Menu;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Helper
 *
 * @author Romain Cottard
 */
trait MenuControllerAwareTrait
{
    /** @var string $menuStateClosed */
    private static string $menuStateClosed = 'closed';

    /** @var array<array<mixed>> $menuConfigMain */
    private array $menuConfigMain;

    /** @var array<array<mixed>> $menuConfigSecondary */
    private array $menuConfigSecondary;

    /** @var string $cookieMenuStateName */
    private string $cookieMenuStateName = '';

    /**
     * @param array<array<mixed>> $menuConfigMain
     * @param string $cookieMenuStateName
     * @param array<array<mixed>> $menuConfigSecondary
     * @return void
     */
    public function setMenuConfig(array $menuConfigMain, string $cookieMenuStateName = '', array $menuConfigSecondary = []): void
    {
        $this->menuConfigMain      = $menuConfigMain;
        $this->menuConfigSecondary = $menuConfigSecondary;
        $this->cookieMenuStateName = $cookieMenuStateName;
    }

    /**
     * Menu with max depth of 2.
     *
     * @param  bool $isMain
     * @param  bool $isLogged
     * @return Menu
     */
    protected function getMenu(bool $isMain = true, bool $isLogged = false): Menu
    {
        $routeParams  = $this->getRoute();
        $currentRoute = $routeParams['_route'] ?? '';
        $menuConfig   = $isMain ? $this->menuConfigMain : $this->menuConfigSecondary;

        $menu = new Menu();
        foreach ($menuConfig as $data) {
            $mustBeLogged = (bool) ($data['mustBeLogged'] ?? false);
            if ($mustBeLogged && !$isLogged) {
                continue;
            }
            $menuRoute       = $data['route'] ?? null;
            $menuRouteParams = $data['route_params'] ?? [];

            $item = new MenuItem($data['label']);
            $item
                ->setUri($this->getMenuUri($menuRoute, $menuRouteParams))
                ->setIcon($data['icon'] ?? '')
                ->setIsActive($menuRoute === $currentRoute)
            ;

            if (!empty($data['children'])) {
                $item->setSubmenu($this->getSubMenu($data['children'], $item, $currentRoute, $isLogged));
            }

            $menu->push($item);
        }

        return $menu;
    }

    /**
     * @param ServerRequestInterface|null $request
     * @return string
     * @codeCoverageIgnore
     */
    protected function getMenuState(?ServerRequestInterface $request): string
    {
        $state = self::$menuStateClosed;

        if ($request === null) {
            return $state;
        }

        $cookie = $request->getCookieParams();

        if (isset($cookie[$this->cookieMenuStateName])) {
            $state = $cookie[$this->cookieMenuStateName];
        }

        return $state;
    }

    /**
     * @param array<array<mixed>> $children
     * @param MenuItem $parent
     * @param string $currentRoute
     * @param bool $isLogged
     * @return Menu
     */
    private function getSubMenu(array $children, MenuItem $parent, string $currentRoute, bool $isLogged = false): Menu
    {
        $menu = new Menu();
        foreach ($children as $data) {
            $mustBeLogged = (bool) ($data['mustBeLogged'] ?? false);
            if ($mustBeLogged && !$isLogged) {
                continue;
            }

            $menuRoute       = $data['route'] ?? null;
            $menuRouteParams = $data['route_params'] ?? [];
            $menuUri         = $this->getMenuUri($menuRoute, $menuRouteParams);

            $item = new MenuItem($data['label']);
            $item
                ->setIsDivider((isset($data['divider']) && (bool) $data['divider']))
                ->setUri($menuUri)
                ->setIcon($data['icon'] ?? '')
                ->setIsActive($currentRoute === $menuRoute)
            ;

            if ($item->isActive()) {
                $parent->setIsActive(true);
            }

            $menu->push($item);
        }

        return $menu;
    }

    /**
     * @param string|null $menuRoute
     * @param array<string> $menuRouteParams
     * @return string
     */
    private function getMenuUri(?string $menuRoute, array $menuRouteParams = []): string
    {
        if (empty($menuRoute)) {
            $menuRoute = '#';
        }

        if (mb_substr($menuRoute, 0, 4) === 'http') {
            $menuUri = $menuRoute;
        } elseif (mb_substr($menuRoute, 0, 1) === '#') {
            $menuUri = 'javascript:void(0);';
        } else {
            $menuUri = $this->getRouteUri($menuRoute, $menuRouteParams);
        }

        return $menuUri;
    }
}
