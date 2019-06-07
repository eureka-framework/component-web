<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\FlashNotifications;

use Eureka\Component\Http\Session\Session;

/**
 * Interface SessionControllerAwareInterface
 *
 * @author Romain Cottard
 */
class FlashNotificationsService
{
    /** @var Session $sesion */
    private $session;

    /**
     * FlashNotificationsService constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $message
     * @param string $type
     * @return void
     */
    public function add(string $message, string $type = FlashNotificationsType::FLASH_SUCCESS): void
    {
        $flash   = $this->session->getEphemeral($type, []);
        $flash[] = $message;

        $this->session->setEphemeral($type, $flash);
    }

    /**
     * @param iterable $errors
     * @return void
     */
    public function setFormErrors(iterable $errors): void
    {
        $this->session->setEphemeral('_form', $errors);
    }

    /**
     * @return iterable Form errors
     */
    public function getFormErrors(): iterable
    {
        return $this->session->getEphemeral('_form', []);
    }

    /**
     * @param string $type
     * @return iterable
     */
    public function get(string $type = FlashNotificationsType::FLASH_SUCCESS): iterable
    {
        return $this->session->getEphemeral($type, []);
    }

    /**
     * @return \stdClass
     */
    public function getAll(): \stdClass
    {
        $notifications = new \stdClass();
        foreach (FlashNotificationsType::ALL_FLASH as $type) {
            $notifications->$type = $this->get($type);
        }

        return $notifications;
    }

    /**
     * @return void
     */
    public function clear()
    {
        /*foreach (FlashNotificationsType::ALL_FLASH as $type) {
            $this->session->setEphemeral($type, []);
        }*/
    }
}
