<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
    private static $menuStateClosed = 'closed';

    /** @var array $menuConfigMain */
    private $menuConfigMain;

    /** @var array $menuConfigSecondary */
    private $menuConfigSecondary;

    /** @var string $cookieMenuStateName */
    private $cookieMenuStateName = '';

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
     * @return Menu
     */
    protected function getMenu(bool $isMain = true): Menu
    {
        $routeParams  = $this->getRoute();
        $currentRoute = $routeParams['_route'] ?? '';
        $menuConfig   = $isMain ? $this->menuConfigMain : $this->menuConfigSecondary;

        $menu = new Menu();
        foreach ($menuConfig as $data) {
            $menuRoute = $data['route'] ?? null;

            if (isset($data['route'])) {
                if (mb_substr($data['route'], 0, 4) === 'http') {
                    $menuUri = $data['route'];
                } elseif (mb_substr($data['route'], 0, 1) === '#') {
                    $menuUri = 'javascript::void(0);';
                } else {
                    $menuUri = isset($data['route']) ? $this->getRouteUri($data['route']) : '#';
                }
            } else {
                $menuUri = '#';
            }

            $item = new MenuItem($data['label']);
            $item
                ->setUri($menuUri)
                ->setIcon(isset($data['icon']) ? $data['icon'] : '')
                ->setIsActive($menuRoute === $currentRoute)
            ;

            if (!empty($data['children'])) {
                $item->setSubmenu($this->getSubMenu($data['children'], $item, $currentRoute));
            }

            $menu->add($item);
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

            $menu->add($item);
        }

        return $menu;
    }
}
