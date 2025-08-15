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
 * @phpstan-type MenuConfigType array{
 *     label: string,
 *     icon?: string|null,
 *     mustBeLogged?: bool,
 *     route?: string|null,
 *     route_params?: array<string, string|int>,
 *     children?: null|MenuChildConfigType[],
 * }
 * @phpstan-type MenuChildConfigType array{
 *     label: string,
 *     icon?: string|null,
 *     divider?: bool,
 *     mustBeLogged?: bool,
 *     route?: string|null,
 *     route_params?: array<string, string|int>,
 * }
 */
trait MenuControllerAwareTrait
{
    private static string $menuStateClosed = 'closed';

    /** @var MenuConfigType[] $menuConfigMain */
    private array $menuConfigMain;

    /** @var MenuConfigType[] $menuConfigSecondary */
    private array $menuConfigSecondary;
    private string $cookieMenuStateName = '';

    /**
     * @param MenuConfigType[] $menuConfigMain
     * @param MenuConfigType[]  $menuConfigSecondary
     */
    public function setMenuConfig(
        array $menuConfigMain,
        string $cookieMenuStateName = '',
        array $menuConfigSecondary = [],
    ): void {
        $this->menuConfigMain      = $menuConfigMain;
        $this->menuConfigSecondary = $menuConfigSecondary;
        $this->cookieMenuStateName = $cookieMenuStateName;
    }

    /**
     * Menu with max depth of 2.
     */
    protected function getMenu(bool $isMain = true, bool $isLogged = false): Menu
    {
        $routeParams  = $this->getRoute();
        $currentRoute = $routeParams['_route'] ?? '';

        $menuConfig = $isMain ? $this->menuConfigMain : $this->menuConfigSecondary;

        $menu = new Menu();
        foreach ($menuConfig as $data) {
            $mustBeLogged = $data['mustBeLogged'] ?? false;
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

            if (isset($data['children']) && \is_array($data['children']) && $data['children'] !== []) {
                $item->setSubmenu($this->getSubMenu($data['children'], $item, $currentRoute, $isLogged));
            }

            $menu->push($item);
        }

        return $menu;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function getMenuState(?ServerRequestInterface $request): string
    {
        $state = self::$menuStateClosed;

        if ($request === null) {
            return $state;
        }

        $cookie = $request->getCookieParams();

        if (isset($cookie[$this->cookieMenuStateName]) && \is_string($cookie[$this->cookieMenuStateName])) {
            $state = $cookie[$this->cookieMenuStateName];
        }

        return $state;
    }

    /**
     * @param MenuChildConfigType[] $children
     */
    private function getSubMenu(array $children, MenuItem $parent, string $currentRoute, bool $isLogged = false): Menu
    {
        $menu = new Menu();
        foreach ($children as $data) {
            $mustBeLogged = $data['mustBeLogged'] ?? false;
            if ($mustBeLogged && !$isLogged) {
                continue;
            }

            $menuRoute       = $data['route'] ?? null;
            $menuRouteParams = $data['route_params'] ?? [];
            $menuUri         = $this->getMenuUri($menuRoute, $menuRouteParams);

            $item = new MenuItem($data['label']);
            $item
                ->setIsDivider((isset($data['divider']) && $data['divider']))
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
     * @param array<string, string|int> $menuRouteParams
     */
    private function getMenuUri(?string $menuRoute, array $menuRouteParams = []): string
    {
        if ($menuRoute === null || $menuRoute === '') {
            $menuRoute = '#';
        }

        if (\mb_substr($menuRoute, 0, 4) === 'http') {
            $menuUri = $menuRoute;
        } elseif (\mb_substr($menuRoute, 0, 1) === '#') {
            $menuUri = 'javascript:void(0);';
        } else {
            $menuUri = $this->getRouteUri($menuRoute, $menuRouteParams);
        }

        return $menuUri;
    }
}
