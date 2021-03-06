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
class NotificationType
{
    /** @var string FLASH_INFO */
    const INFO    = 'info';

    /** @var string FLASH_SUCCESS */
    const SUCCESS = 'success';

    /** @var string FLASH_WARNING */
    const WARNING = 'warning';

    /** @var string FLASH_ERROR */
    const ERROR   = 'error';

    /** @var string[] ALL_FLASH */
    const LIST = [
        self::INFO,
        self::SUCCESS,
        self::WARNING,
        self::ERROR,
    ];
}
