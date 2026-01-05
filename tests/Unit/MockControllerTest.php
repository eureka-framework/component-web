<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests\Unit;

use Eureka\Component\Web\Menu\Menu;
use Eureka\Component\Web\Menu\MenuControllerAwareTrait;
use Eureka\Component\Web\Menu\MenuItem;
use Eureka\Component\Web\Meta\MetaControllerAwareTrait;
use Eureka\Component\Web\Notification\NotificationType;
use Eureka\Component\Web\Session\Session;
use Eureka\Component\Web\Session\SessionAwareTrait;
use PHPUnit\Framework\TestCase;

/**
 * @phpstan-import-type MenuConfigType from MenuControllerAwareTrait
 */
class MockControllerTest extends TestCase
{
    use MenuControllerAwareTrait;
    use MetaControllerAwareTrait;
    use SessionAwareTrait;

    public function testICanSetAndGetSessionFromTrait(): void
    {
        $_SESSION = [];
        $this->setSession(new Session());

        self::assertInstanceOf(Session::class, $this->getSession());
    }

    public function testICanAddAndRetrieveFlashNotifications(): void
    {
        $this->setSession(new Session());

        $this->addFlashNotification('flash notification', NotificationType::Success);
        self::assertSame(['flash notification'], $this->getFlashNotification(NotificationType::Success));

        $this->addFlashNotification('other notification', NotificationType::Info);

        self::assertEquals(
            (object) [
                NotificationType::Success->value => ['flash notification'],
                NotificationType::Info->value    => ['other notification'],
                NotificationType::Warning->value => [],
                NotificationType::Error->value   => [],
            ],
            $this->getAllFlashNotification(),
        );
    }

    public function testICanSetAndRetrieveFormErrors(): void
    {
        $this->setSession(new Session());

        $this->setFormErrors(['invalid password']);

        self::assertSame(['invalid password'], $this->getFormErrors());
    }

    public function testICanSetAndRetrieveMetaConfig(): void
    {
        $this->setMetaConfig([
            'copyright' => [
                'year' => 'now',
                'name' => 'me',
            ],
            'title' => 'test',
        ]);

        /** @var array{copyright: array{year?: string, name?: string}, title?: string} $meta */
        $meta = $this->getMeta();

        self::assertSame(date('Y'), $meta['copyright']['year'] ?? '');
        self::assertSame('me', $meta['copyright']['name'] ?? '');
        self::assertSame('test', $meta['title'] ?? '');
    }

    public function testICanSetMenuConfigAndGetPartialMenuCollectionWhenIAmNotLogged(): void
    {
        $this->setMenuConfig($this->getTestMenuConfig(), 'open');

        $menu    = $this->getMenu();
        $subMenu = $menu->get('Test')?->getSubmenu() ?? new Menu();

        self::assertInstanceOf(MenuItem::class, $menu->get('Home'));
        self::assertInstanceOf(MenuItem::class, $menu->get('Test'));
        self::assertInstanceOf(MenuItem::class, $subMenu->get('Sub Test 1'));
        self::assertInstanceOf(MenuItem::class, $subMenu->get('Sub Test 2'));
        self::assertInstanceOf(MenuItem::class, $subMenu->get('Sub Test 3'));

        self::assertNull($menu->get('Logged'));
        self::assertNull($subMenu->get('Sub Test 4'));
    }

    public function testICanSetMenuConfigAndGetCompleteMenuCollectionWhenIAmLogged(): void
    {
        $this->setMenuConfig($this->getTestMenuConfig(), 'open');

        $menu = $this->getMenu(true, true);

        $item1 = $menu->get('Home') ?? new MenuItem('void');
        self::assertSame('Home', $item1->getName());
        self::assertSame('', $item1->getIcon());
        self::assertSame('/home', $item1->getUri());
        self::assertFalse($item1->hasSubmenu());
        self::assertFalse($item1->hasIcon());
        self::assertFalse($item1->isActive());

        $item2 = $menu->get('Test') ?? new MenuItem('void');
        self::assertSame('Test', $item2->getName());
        self::assertSame('ico', $item2->getIcon());
        self::assertSame('javascript:void(0);', $item2->getUri());
        self::assertTrue($item2->hasSubmenu());
        self::assertTrue($item2->hasIcon());
        self::assertTrue($item2->isActive());

        $item3 = $menu->get('Logged') ?? new MenuItem('void');
        self::assertSame('Logged', $item3->getName());
        self::assertSame('', $item3->getIcon());
        self::assertSame('/home', $item3->getUri());
        self::assertFalse($item3->hasSubmenu());
        self::assertFalse($item3->hasIcon());
        self::assertFalse($item3->isActive());

        $subItem1 = $item2->getSubmenu()?->get('Sub Test 1') ?? new MenuItem('void');
        self::assertSame('Sub Test 1', $subItem1->getName());
        self::assertSame('', $subItem1->getIcon());
        self::assertSame('javascript:void(0);', $subItem1->getUri());
        self::assertFalse($subItem1->hasSubmenu());
        self::assertFalse($subItem1->hasIcon());
        self::assertFalse($subItem1->isActive());

        $subItem2 = $item2->getSubmenu()?->get('Sub Test 2') ?? new MenuItem('void');
        self::assertSame('Sub Test 2', $subItem2->getName());
        self::assertSame('', $subItem2->getIcon());
        self::assertSame('http://external.com', $subItem2->getUri());
        self::assertFalse($subItem2->hasSubmenu());
        self::assertFalse($subItem2->hasIcon());
        self::assertFalse($subItem2->isActive());

        $subItem3 = $item2->getSubmenu()?->get('Sub Test 3') ?? new MenuItem('void');
        self::assertSame('Sub Test 3', $subItem3->getName());
        self::assertSame('', $subItem3->getIcon());
        self::assertSame('/home', $subItem3->getUri());
        self::assertFalse($subItem3->hasSubmenu());
        self::assertFalse($subItem3->hasIcon());
        self::assertTrue($subItem3->isActive());

        $subItem4 = $item2->getSubmenu()?->get('Sub Test 4') ?? new MenuItem('void');
        self::assertSame('Sub Test 4', $subItem4->getName());
        self::assertSame('', $subItem4->getIcon());
        self::assertSame('/home', $subItem4->getUri());
        self::assertFalse($subItem4->hasSubmenu());
        self::assertFalse($subItem4->hasIcon());
        self::assertFalse($subItem4->isActive());
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
     * @param array<string, string|int> $params
     */
    protected function getRouteUri(string $routeName, array $params = []): string
    {
        return '/home';
    }

    /**
     * @return MenuConfigType[]
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
