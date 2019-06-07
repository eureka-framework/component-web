<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\FlashNotifications;

/**
 * Class SessionFlashType
 *
 * @author Romain Cottard
 */
class FlashNotificationsType
{
    /** @var string FLASH_INFO */
    const FLASH_INFO    = 'info';

    /** @var string FLASH_SUCCESS */
    const FLASH_SUCCESS = 'success';

    /** @var string FLASH_WARNING */
    const FLASH_WARNING = 'warning';

    /** @var string FLASH_ERROR */
    const FLASH_ERROR   = 'error';

    /** @var string[] ALL_FLASH */
    const ALL_FLASH = [
        self::FLASH_INFO,
        self::FLASH_SUCCESS,
        self::FLASH_WARNING,
        self::FLASH_ERROR,
    ];
}
