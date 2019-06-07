<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\Notification;

/**
 * Class for basic notifications on actions (save, delete...)
 *
 * @author  Romain Cottard
 */
interface NotificationInterface
{
    /** @var int TYPE_ERROR */
    public const TYPE_ERROR = 1;

    /** @var int TYPE_WARNING */
    public const TYPE_WARNING = 2;

    /** @var int TYPE_INFO */
    public const TYPE_INFO = 3;

    /** @var int TYPE_SUCCESS */
    public const TYPE_SUCCESS = 4;

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Get css
     *
     * @return string
     */
    public function getCss(): string;

    /**
     * Get Icon
     *
     * @return string
     */
    public function getIcon(): string;

    /**
     * Get header message.
     *
     * @return string
     */
    public function getHeader(): string;
}
