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

    /** @var array $menuConfig */
    private $menuConfig;

    /** @var string $cookieMenuStateName */
    private $cookieMenuStateName = '';

    /**
     * @param array $menuConfig
     * @param string $cookieMenuStateName
     * @return void
     */
    public function setMenuConfig(array $menuConfig, string $cookieMenuStateName = ''): void
    {
        $this->menuConfig = $menuConfig;
        $this->cookieMenuStateName = $cookieMenuStateName;
    }

    /**
     * Menu with max depth of 2.
     *
     * @return Menu
     */
    protected function getMenu(): Menu
    {
        $routeParams  = $this->getRoute();
        $currentRoute = isset($routeParams['_route']) ? $routeParams['_route'] : '';

        $menu = new Menu();
        foreach ($this->menuConfig as $data) {
            $menuUri = isset($data['route']) ? $this->getUri($data['route']) : '#';

            $item = new MenuItem($data['label']);
            $item
                ->setUri($menuUri)
                ->setIcon(isset($data['icon']) ? $data['icon'] : '')
                ->setIsActive(false)
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
            $menuUri   = $menuRoute !== null ? $this->getUri($data['route']) : '#';

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
