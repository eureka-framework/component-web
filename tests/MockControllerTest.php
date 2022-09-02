<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests;

use Eureka\Component\Web\Menu\Menu;
use Eureka\Component\Web\Menu\MenuControllerAwareTrait;
use Eureka\Component\Web\Menu\MenuItem;
use Eureka\Component\Web\Meta\MetaControllerAwareTrait;
use Eureka\Component\Web\Notification\NotificationType;
use Eureka\Component\Web\Session\Session;
use Eureka\Component\Web\Session\SessionAwareTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class MockControllerTest
 *
 * @author Romain Cottard
 */
class MockControllerTest extends TestCase
{
    use MenuControllerAwareTrait;
    use MetaControllerAwareTrait;
    use SessionAwareTrait;

    /**
     * @return void
     */
    public function testICanSetAndGetSessionFromTrait(): void
    {
        $_SESSION = [];
        $this->setSession(new Session());

        $this->assertInstanceOf(Session::class, $this->getSession());
    }

    public function testICanAddAndRetrieveFlashNotifications(): void
    {
        $this->setSession(new Session());

        $this->addFlashNotification('flash notification');
        $this->assertSame(['flash notification'], $this->getFlashNotification(NotificationType::SUCCESS));

        $this->addFlashNotification('other notification', NotificationType::INFO);

        $this->assertEquals(
            (object) [
                NotificationType::SUCCESS => ['flash notification'],
                NotificationType::INFO    => ['other notification'],
                NotificationType::WARNING => [],
                NotificationType::ERROR   => [],
            ],
            $this->getAllFlashNotification()
        );
    }

    public function testICanSetAndRetrieveFormErrors(): void
    {
        $this->setSession(new Session());

        $this->setFormErrors(['invalid password']);

        $this->assertSame(['invalid password'], $this->getFormErrors());
    }

    public function testICanSetAndRetrieveMetaConfig(): void
    {
        $this->setMetaConfig([
            'copyright' => [
                'year' => 'now',
                'name' => 'me'
            ],
            'title' => 'test',
        ]);

        $meta = $this->getMeta();

        $this->assertEquals(date('Y'), $meta['copyright']['year'] ?? '');
        $this->assertEquals('me', $meta['copyright']['name'] ?? '');
        $this->assertEquals('test', $meta['title'] ?? '');
    }

    public function testICanSetMenuConfigAndGetPartialMenuCollectionWhenIAmNotLogged(): void
    {
        $this->setMenuConfig($this->getTestMenuConfig(), 'open', []);

        $menu    = $this->getMenu();
        $subMenu = $menu->get('Test') && $menu->get('Test')->getSubmenu() ? $menu->get('Test')->getSubmenu() : new Menu();

        $this->assertInstanceOf(MenuItem::class, $menu->get('Home'));
        $this->assertInstanceOf(MenuItem::class, $menu->get('Test'));
        $this->assertInstanceOf(MenuItem::class, $subMenu->get('Sub Test 1'));
        $this->assertInstanceOf(MenuItem::class, $subMenu->get('Sub Test 2'));
        $this->assertInstanceOf(MenuItem::class, $subMenu->get('Sub Test 3'));

        $this->assertNull($menu->get('Logged'));
        $this->assertNull($subMenu->get('Sub Test 4'));
    }

    public function testICanSetMenuConfigAndGetCompleteMenuCollectionWhenIAmLogged(): void
    {
        $this->setMenuConfig($this->getTestMenuConfig(), 'open', []);

        $menu = $this->getMenu(true, true);

        $item1 = $menu->get('Home') ?? new MenuItem('void');
        $this->assertEquals('Home', $item1->getName());
        $this->assertEquals('', $item1->getIcon());
        $this->assertEquals('/home', $item1->getUri());
        $this->assertFalse($item1->hasSubmenu());
        $this->assertFalse($item1->hasIcon());
        $this->assertFalse($item1->isActive());

        $item2 = $menu->get('Test') ?? new MenuItem('void');
        $this->assertEquals('Test', $item2->getName());
        $this->assertEquals('ico', $item2->getIcon());
        $this->assertEquals('javascript:void(0);', $item2->getUri());
        $this->assertTrue($item2->hasSubmenu());
        $this->assertTrue($item2->hasIcon());
        $this->assertTrue($item2->isActive());

        $item3 = $menu->get('Logged') ?? new MenuItem('void');
        $this->assertEquals('Logged', $item3->getName());
        $this->assertEquals('', $item3->getIcon());
        $this->assertEquals('/home', $item3->getUri());
        $this->assertFalse($item3->hasSubmenu());
        $this->assertFalse($item3->hasIcon());
        $this->assertFalse($item3->isActive());

        $subItem1 = $item2->getSubmenu() && $item2->getSubmenu()->get('Sub Test 1') ? $item2->getSubmenu()->get('Sub Test 1') :  new MenuItem('void');
        $this->assertEquals('Sub Test 1', $subItem1->getName());
        $this->assertEquals('', $subItem1->getIcon());
        $this->assertEquals('javascript:void(0);', $subItem1->getUri());
        $this->assertFalse($subItem1->hasSubmenu());
        $this->assertFalse($subItem1->hasIcon());
        $this->assertFalse($subItem1->isActive());

        $subItem2 = $item2->getSubmenu() && $item2->getSubmenu()->get('Sub Test 2') ? $item2->getSubmenu()->get('Sub Test 2') :  new MenuItem('void');
        $this->assertEquals('Sub Test 2', $subItem2->getName());
        $this->assertEquals('', $subItem2->getIcon());
        $this->assertEquals('http://external.com', $subItem2->getUri());
        $this->assertFalse($subItem2->hasSubmenu());
        $this->assertFalse($subItem2->hasIcon());
        $this->assertFalse($subItem2->isActive());

        $subItem3 = $item2->getSubmenu() && $item2->getSubmenu()->get('Sub Test 3') ? $item2->getSubmenu()->get('Sub Test 3') :  new MenuItem('void');
        $this->assertEquals('Sub Test 3', $subItem3->getName());
        $this->assertEquals('', $subItem3->getIcon());
        $this->assertEquals('/home', $subItem3->getUri());
        $this->assertFalse($subItem3->hasSubmenu());
        $this->assertFalse($subItem3->hasIcon());
        $this->assertTrue($subItem3->isActive());

        $subItem4 = $item2->getSubmenu() && $item2->getSubmenu()->get('Sub Test 4') ? $item2->getSubmenu()->get('Sub Test 4') :  new MenuItem('void');
        $this->assertEquals('Sub Test 4', $subItem4->getName());
        $this->assertEquals('', $subItem4->getIcon());
        $this->assertEquals('/home', $subItem4->getUri());
        $this->assertFalse($subItem4->hasSubmenu());
        $this->assertFalse($subItem4->hasIcon());
        $this->assertFalse($subItem4->isActive());
    }
    /**
     * Emulate getRoute() in application.
     *
     * @return array<string,string>
     */
    protected function getRoute(): array
    {
        return [
            '_route' => 'sub_test_3',
        ];
    }

    /**
     * Emulate getRouteUri() in application.
     *
     * @param string $routeName
     * @param array<string> $params
     * @return string
     */
    protected function getRouteUri(string $routeName, array $params = []): string
    {
        return '/home';
    }

    /**
     * @return array<array<mixed>>
     */
    private function getTestMenuConfig(): array
    {
        return [
            'home' => [
                'label'        => 'Home',
                'icon'         => '',
                'mustBeLogged' => false,
                'route'        => 'home',
            ],
            'test' => [
                'label'    => 'Test',
                'icon'     => 'ico',
                'route'    => null,
                'children' => [
                    0 => [
                        'label' => 'Sub Test 1',
                        'icon'  => '',
                        'route' => '#',
                    ],
                    2 => [
                        'label' => 'Sub Test 2',
                        'icon'  => '',
                        'route' => 'http://external.com',
                    ],
                    3 => [
                        'label' => 'Sub Test 3',
                        'icon'  => '',
                        'route' => 'sub_test_3',
                        'mustBeLogged' => false,
                    ],
                    4 => [
                        'label' => 'Sub Test 4',
                        'icon'  => '',
                        'route' => 'sub_test_4',
                        'mustBeLogged' => true,
                    ],
                ],
            ],
            'logged' => [
                'label'        => 'Logged',
                'icon'         => '',
                'mustBeLogged' => true,
                'route'        => 'home',
            ],
        ];
    }
}
