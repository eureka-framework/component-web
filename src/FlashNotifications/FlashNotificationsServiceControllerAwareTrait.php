<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\FlashNotifications;


/**
 * Trait SessionControllerAwareTrait
 *
 * @author Romain Cottard
 */
trait FlashNotificationsServiceControllerAwareTrait
{
    /** @var FlashNotificationsService $flashNotificationsService */
    private $flashNotificationsService;

    /**
     * @param FlashNotificationsService $flashNotificationsService
     * @return void
     */
    public function setFlashNotificationsService(FlashNotificationsService $flashNotificationsService)
    {
        $this->flashNotificationsService = $flashNotificationsService;
    }

    /**
     * @return FlashNotificationsService
     */
    protected function getFlashNotificationsService(): FlashNotificationsService
    {
        return $this->flashNotificationsService;
    }

    /**
     * @param string $message
     * @param string $type
     * @return void
     */
    protected function addFlash(string $message, string $type = FlashNotificationsType::FLASH_SUCCESS): void
    {
        $this->flashNotificationsService->add($message, $type);
    }

    /**
     * @param string $type
     * @return iterable
     */
    protected function getFlash(string $type = FlashNotificationsType::FLASH_SUCCESS): iterable
    {
        return $this->flashNotificationsService->get($type);
    }

    /**
     * @return \stdClass
     */
    protected function getAllFlash(): \stdClass
    {
        return $this->flashNotificationsService->getAll();
    }

    /**
     * @param iterable $errors
     * @return void
     */
    protected function setFlashFormErrors(iterable $errors = []): void
    {
        $this->flashNotificationsService->setFormErrors($errors);
    }

    /**
     * @return iterable
     */
    protected function getFlashFormErrors(): iterable
    {
        return $this->flashNotificationsService->getFormErrors();
    }
}
