<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests\Unit;

use Eureka\Component\Web\Notification\NotificationCollection;
use Eureka\Component\Web\Notification\NotificationBootstrap;
use Eureka\Component\Web\Notification\NotificationInterface;
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

        /** @var NotificationInterface $item */
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
     * @dataProvider dataProviderNotification
     */
    public function testICanSetAndRetrieveAllInformationOnItem(
        string $message,
        NotificationType $type,
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

        $notification->setMessage($message);
        $notification->setType($type);
        $this->assertSame($message, $notification->getMessage());
        $this->assertSame($type, $notification->getType());
    }

    /**
     * @return array<string, array{0: string, 1: NotificationType, 2: string, 3: string, 4: string}>
     */
    public static function dataProviderNotification(): array
    {
        return [
            'Type info' => [
                'notification success',
                NotificationType::Info,
                'info', // css
                'info', // icon
                'Info', // header
            ],
            'Type success' => [
                'notification success',
                NotificationType::Success,
                'success', // css
                'check', // icon
                'Success', // header
            ],
            'Type warning' => [
                'notification warning',
                NotificationType::Warning,
                'warning', // css
                'warning', // icon
                'Warning!', // header
            ],
            'Type error' => [
                'notification error',
                NotificationType::Error,
                'danger', // css
                'ban', // icon
                'Error!', // header
            ],
        ];
    }
}
