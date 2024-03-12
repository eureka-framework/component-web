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
 * @author Romain Cottard
 */
abstract class AbstractNotification implements NotificationInterface
{
    public function __construct(
        protected string $message,
        protected NotificationType $type = NotificationType::Success
    ) {}

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): NotificationType
    {
        return $this->type;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function setType(NotificationType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
