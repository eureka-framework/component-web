<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Notification;

interface NotificationInterface
{
    public function getMessage(): string;

    public function getCss(): string;

    public function getIcon(): string;

    public function getHeader(): string;
}
