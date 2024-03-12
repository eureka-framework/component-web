<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Session;

use Eureka\Component\Web\Notification\NotificationType;

/**
 * Trait SessionAwareTrait
 *
 * @author Romain Cottard
 */
trait SessionAwareTrait
{
    /** @var Session|null session */
    protected Session|null $session = null;

    /**
     * @param Session $session
     * @return void
     */
    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    protected function getSession(): Session|null
    {
        return $this->session;
    }

    public function addFlashNotification(string $message, NotificationType $type): void
    {
        if ($this->session === null) {
            return;
        }

        /** @var array<mixed> $flash */
        $flash   = $this->session->getFlash($type->value, []);
        $flash[] = $message;

        $this->session->setFlash($type->value, $flash);
    }

    /**
     * @param array<mixed> $errors
     * @return void
     */
    public function setFormErrors(array $errors): void
    {
        if ($this->session === null) {
            return;
        }

        $this->session->setFlash('_form', $errors);
    }

    /**
     * @return array<mixed> Form errors
     */
    public function getFormErrors(): array
    {
        if ($this->session === null) {
            return [];
        }

        /** @var array<mixed> $data */
        $data = $this->session->getFlash('_form', []);

        return $data;
    }

    /**
     * @return array<mixed>
     */
    public function getFlashNotification(NotificationType $type): array
    {
        if ($this->session === null) {
            return [];
        }

        /** @var array<mixed> $data */
        $data = $this->session->getFlash($type->value, []);

        return $data;
    }

    public function getAllFlashNotification(): \stdClass
    {
        if ($this->session === null) {
            return (object) [];
        }

        $notifications = new \stdClass();
        foreach (NotificationType::List as $type) {
            $notifications->{$type->value} = $this->getFlashNotification($type);
        }

        return $notifications;
    }
}
