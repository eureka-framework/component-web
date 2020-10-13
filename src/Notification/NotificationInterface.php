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
 * Class for basic notifications on actions (save, delete...)
 *
 * @author  Romain Cottard
 */
interface NotificationInterface
{
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
