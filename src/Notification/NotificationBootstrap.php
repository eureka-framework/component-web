<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Notification;

class NotificationBootstrap extends AbstractNotification
{
    public function getCss(): string
    {
        return match ($this->type) {
            NotificationType::Error   => 'danger',
            NotificationType::Warning => 'warning',
            NotificationType::Success => 'success',
            default                   => 'info',
        };
    }

    public function getHeader(): string
    {
        return match ($this->type) {
            NotificationType::Error   => 'Error!',
            NotificationType::Warning => 'Warning!',
            NotificationType::Success => 'Success',
            default                   => 'Info',
        };
    }

    public function getIcon(): string
    {
        return match ($this->type) {
            NotificationType::Error   => 'ban',
            NotificationType::Warning => 'warning',
            NotificationType::Success => 'check',
            default                   => 'info',
        };
    }
}
