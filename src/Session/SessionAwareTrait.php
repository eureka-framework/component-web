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
    protected ?Session $session = null;

    /**
     * @param Session $session
     * @return void
     */
    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    /**
     * @return Session|null
     */
    protected function getSession(): ?Session
    {
        return $this->session;
    }

    /**
     * @param string $message
     * @param string $type
     * @return void
     */
    public function addFlashNotification(string $message, string $type = NotificationType::SUCCESS): void
    {
        if ($this->session === null) {
            return;
        }

        /** @var array<mixed> $flash */
        $flash   = $this->session->getFlash($type, []);
        $flash[] = $message;

        $this->session->setFlash($type, $flash);
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
     * @param string $type
     * @return array<mixed>
     */
    public function getFlashNotification(string $type = NotificationType::SUCCESS): array
    {
        if ($this->session === null) {
            return [];
        }

        /** @var array<mixed> $data */
        $data = $this->session->getFlash($type, []);

        return $data;
    }

    /**
     * @return \stdClass
     */
    public function getAllFlashNotification(): \stdClass
    {
        if ($this->session === null) {
            return (object) [];
        }

        $notifications = new \stdClass();
        foreach (NotificationType::LIST as $type) {
            $notifications->$type = $this->getFlashNotification($type);
        }

        return $notifications;
    }
}
