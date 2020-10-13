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
    /** @var string $message Message */
    protected string $message = '';

    /** @var string $type Notification type */
    protected string $type;

    /**
     * Notification constructor.
     *
     * @param string $message
     * @param string $type
     */
    public function __construct(string $message, string $type = NotificationType::SUCCESS)
    {
        $this->setMessage($message);
        $this->setType($type);
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set message
     *
     * @param  string $message
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set type
     *
     * @param  string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
