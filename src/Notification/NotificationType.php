<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Notification;

/**
 * Class NotificationType
 *
 * @author Romain Cottard
 */
enum NotificationType: string
{
    case Info    = 'info';
    case Success = 'success';
    case Warning = 'warning';
    case Error   = 'error';

    /** @var NotificationType[] List */
    public const List = [
        self::Info,
        self::Success,
        self::Warning,
        self::Error,
    ];
}
