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
class NotificationBootstrap extends AbstractNotification
{
    /**
     * Get css used.
     *
     * @return string
     */
    public function getCss(): string
    {
        switch ($this->type) {
            case NotificationType::ERROR:
                $css = 'danger';
                break;
            case NotificationType::WARNING:
                $css = 'warning';
                break;
            case NotificationType::SUCCESS:
                $css = 'success';
                break;
            case NotificationType::INFO:
            default:
                $css = 'info';
                break;
        }

        return $css;
    }

    /**
     * Get header title.
     *
     * @return string
     */
    public function getHeader(): string
    {
        switch ($this->type) {
            case NotificationType::ERROR:
                $header = 'Error!';
                break;
            case NotificationType::WARNING:
                $header = 'Warning!';
                break;
            case NotificationType::SUCCESS:
                $header = 'Success';
                break;
            case NotificationType::INFO:
            default:
                $header = 'Info';
                break;
        }

        return $header;
    }

    /**
     * Return icon name.
     *
     * @return string
     */
    public function getIcon(): string
    {
        switch ($this->type) {
            case NotificationType::ERROR:
                $icon = 'ban';
                break;
            case NotificationType::WARNING:
                $icon = 'warning';
                break;
            case NotificationType::SUCCESS:
                $icon = 'check';
                break;
            case NotificationType::INFO:
            default:
                $icon = 'info';
                break;
        }

        return $icon;
    }
}
