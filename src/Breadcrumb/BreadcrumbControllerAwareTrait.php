<?php

/*
 * Copyright (c) Deezer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\Breadcrumb;

/**
 * Trait BreadcrumbControllerAwareTrait
 *
 * @author Romain Cottard
 */
trait BreadcrumbControllerAwareTrait
{
    /** @var array $menuConfig */
    private $menuConfig;

    /**
     * @param array $menuConfig
     * @return void
     */
    public function setMenuConfig(array $menuConfig)
    {
        $this->menuConfig = $menuConfig;
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
