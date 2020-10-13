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
    /** @var Session session */
    protected Session $session;

    /**
     * @param Session $session
     * @return void
     */
    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    /**
     * @return Session
     */
    protected function getSession(): Session
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
        $flash   = $this->session->getFlash($type, []);
        $flash[] = $message;

        $this->session->setFlash($type, $flash);
    }

    /**
     * @param array $errors
     * @return void
     */
    public function setFormErrors(array $errors): void
    {
        $this->session->setFlash('_form', $errors);
    }

    /**
     * @return array Form errors
     */
    public function getFormErrors(): array
    {
        return $this->session->getFlash('_form', []);
    }

    /**
     * @param string $type
     * @return array
     */
    public function get(string $type = NotificationType::SUCCESS): array
    {
        return $this->session->getFlash($type, []);
    }

    /**
     * @return \stdClass
     */
    public function getAll(): \stdClass
    {
        $notifications = new \stdClass();
        foreach (NotificationType::LIST as $type) {
            $notifications->$type = $this->get($type);
        }

        return $notifications;
    }
}
