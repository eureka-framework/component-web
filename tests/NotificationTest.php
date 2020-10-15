<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests;

use Eureka\Component\Web\Notification\NotificationCollection;
use Eureka\Component\Web\Notification\NotificationBootstrap;
use Eureka\Component\Web\Notification\NotificationType;
use PHPUnit\Framework\TestCase;

/**
 * Class NotificationTest
 *
 * @author Romain Cottard
 */
class NotificationTest extends TestCase
{
    /**
     * @return void
     */
    public function testICanInitializeNotification(): void
    {
        $notifications = new NotificationCollection();

        $this->assertInstanceOf(NotificationCollection::class, $notifications);
    }

    /**
     * @return void
     */
    public function testICanPushAndGetItemToNotification(): void
    {
        $notifications = new NotificationCollection();
        $notifications->push(new NotificationBootstrap('item 1'));
        $notifications->push(new NotificationBootstrap('item 2'));

        $item = $notifications->pop();

        $this->assertEquals('item 2', $item->getMessage());
    }

    /**
     * @return void
     */
    public function testICanIterateOnNotificationInstance(): void
    {
        $notifications = new NotificationCollection();
        $notifications->push(new NotificationBootstrap('item 1'));
        $notifications->push(new NotificationBootstrap('item 2'));

        foreach ($notifications as $index => $item) {
            $this->assertEquals('item ' . ($index + 1), $item->getMessage());
        }
    }

    /**
     * @return void
     */
    public function testICanCountItemInNotification(): void
    {
        $notifications = new NotificationCollection();
        $notifications->push(new NotificationBootstrap('item 1'));
        $notifications->push(new NotificationBootstrap('item 2'));

        $this->assertCount(2, $notifications);
        $this->assertEquals(2, count($notifications));
    }

    /**
     * @return void
     */
    public function testICanCheckIfItIsTheFirstItemDuringTheIterationOnNotification(): void
    {
        $notifications = new NotificationCollection();
        $notifications->push(new NotificationBootstrap('item 1'));
        $notifications->push(new NotificationBootstrap('item 2'));

        $notifications->rewind();

        $this->assertTrue($notifications->isFirst());
    }

    /**
     * @return void
     */
    public function testICanCheckIfItIsTheLastItemDuringTheIterationOnNotification(): void
    {
        $notifications = new NotificationCollection();
        $notifications->push(new NotificationBootstrap('item 1'));
        $notifications->push(new NotificationBootstrap('item 2'));

        $notifications->rewind();
        $notifications->next();

        $this->assertTrue($notifications->isLast());
    }

    /**
     * @param string $message
     * @param string $type
     * @param string $css
     * @param string $icon
     * @param string $header
     * @return void
     *
     * @dataProvider dataProviderNotification
     */
    public function testICanSetAndRetrieveAllInformationOnItem(
        string $message,
        string $type,
        string $css,
        string $icon,
        string $header
    ): void {
        $notification = new NotificationBootstrap($message, $type);

        $this->assertSame($message, $notification->getMessage());
        $this->assertSame($type, $notification->getType());
        $this->assertSame($css, $notification->getCss());
        $this->assertSame($icon, $notification->getIcon());
        $this->assertSame($header, $notification->getHeader());
    }

    /**
     * @return array[]
     */
    public function dataProviderNotification(): array
    {
        return [
            'Type info' => [
                'notification success',
                NotificationType::INFO,
                'info', // css
                'info', // icon
                'Info', // header
            ],
            'Type success' => [
                'notification success',
                NotificationType::SUCCESS,
                'success', // css
                'check', // icon
                'Success', // header
            ],
            'Type warning' => [
                'notification warning',
                NotificationType::WARNING,
                'warning', // css
                'warning', // icon
                'Warning!', // header
            ],
            'Type error' => [
                'notification error',
                NotificationType::ERROR,
                'danger', // css
                'ban', // icon
                'Error!', // header
            ],
        ];
    }
}
