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

    /** @var array $menuConfigMain */
    private array $menuConfigMain;

    /** @var array $menuConfigSecondary */
    private array $menuConfigSecondary;

    /** @var string $cookieMenuStateName */
    private string $cookieMenuStateName = '';

    /**
     * @param array $menuConfigMain
     * @param string $cookieMenuStateName
     * @param array $menuConfigSecondary
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
            $menuRoute = $data['route'] ?? null;

            $item = new MenuItem($data['label']);
            $item
                ->setUri($this->getMenuUri($menuRoute))
                ->setIcon(isset($data['icon']) ? $data['icon'] : '')
                ->setIsActive($menuRoute === $currentRoute)
            ;

            if (!empty($data['children'])) {
                $item->setSubmenu($this->getSubMenu($data['children'], $item, $currentRoute));
            }

            $menu->push($item);
        }

        return $menu;
    }

    /**
     * @param null|ServerRequestInterface $request
     * @return string
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
     * @param array $children
     * @param MenuItem $parent
     * @param string $currentRoute
     * @return Menu
     */
    private function getSubMenu(array $children, MenuItem $parent, string $currentRoute): Menu
    {
        $menu = new Menu();
        foreach ($children as $data) {
            $menuRoute = isset($data['route']) ? $data['route'] : null;
            $menuUri   = $menuRoute !== null ? $this->getRouteUri($data['route']) : '#';

            $item = new MenuItem($data['label']);
            $item
                ->setIsDivider((isset($data['divider']) ? (bool) $data['divider'] : false))
                ->setUri($menuUri)
                ->setIcon(isset($data['icon']) ? $data['icon'] : '')
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
     * @return string
     */
    private function getMenuUri(?string $menuRoute): string
    {
        if (empty($menuRoute)) {
            $menuRoute = '#';
        }

        if (mb_substr($menuRoute, 0, 4) === 'http') {
            $menuUri = $menuRoute;
        } elseif (mb_substr($menuRoute, 0, 1) === '#') {
            $menuUri = 'javascript::void(0);';
        } else {
            $menuUri = $this->getRouteUri($menuRoute);
        }

        return $menuUri;
    }
}
