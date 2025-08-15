<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Session;

/**
 * $_SESSION data wrapper class.
 * Can handle flash (ephemeral) session variables.
 */
class Session
{
    /** @var string FLASH Session index name for ephemeral var in Session. */
    private const string FLASH = '_flash';

    /** @var string ACTIVE Session index name for ephemeral var if active or not. */
    private const string ACTIVE = 'active';

    /** @var string VARIABLE Session index name for ephemeral var content. */
    private const string VARIABLE = 'var';

    /** @var array<mixed>|null $session */
    protected static ?array $session = null;

    public function __construct()
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        if (self::$session === null) {
            self::$session = []; // default

            if (isset($_SESSION)) {
                self::$session = &$_SESSION; // @codeCoverageIgnore
            }
        }

        $this->clearFlash();
    }

    /**
     * If session have given key.
     */
    public function has(string $key): bool
    {
        return isset(self::$session[$key]);
    }

    /**
     * Get session value.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return self::$session[$key] ?? $default;
    }

    /**
     * Set value for a given key.
     */
    public function set(string $key, mixed $value): self
    {
        self::$session[$key] = $value;

        return $this;
    }

    /**
     * Remove key from bag container.
     * If key not exists, must throw an BagKeyNotFoundException
     */
    public function remove(string $key): self
    {
        if ($this->has($key)) {
            unset(self::$session[$key]);
        }

        return $this;
    }

    /**
     * Get Session ephemeral variable specified.
     */
    public function getFlash(string $name, mixed $default = null): mixed
    {
        /** @var array<array<mixed>> $flash */
        $flash = $this->get(self::FLASH);
        if (!isset($flash[$name][self::VARIABLE]) && !isset($flash[$name])) {
            return $default;
        }

        return $flash[$name][self::VARIABLE];
    }

    /**
     * Check if have specified ephemeral var in Session.
     */
    public function hasFlash(string $name): bool
    {
        /** @var array<mixed> $flash */
        $flash = $this->get(self::FLASH);

        return isset($flash[$name]);
    }

    /**
     * Initialize Session. Remove old ephemeral var in Session.
     */
    public function clearFlash(): self
    {
        //~ Check ephemeral vars
        if (!$this->has(self::FLASH)) {
            $this->set(self::FLASH, []);

            return $this;
        }

        /** @var array<array<mixed>> $flash */
        $flash = $this->get(self::FLASH);
        foreach ($flash as $name => &$var) {
            if (true === $var[self::ACTIVE]) {
                $var[self::ACTIVE] = false;
            } else {
                unset($flash[$name]);
            }
        }

        //~ Save in Session.
        $this->set(self::FLASH, $flash);

        return $this;
    }

    /**
     * Set ephemeral variable in Session.
     */
    public function setFlash(string $name, mixed $value): self
    {
        /** @var array<array<mixed>> $flash */
        $flash = $this->get(self::FLASH);

        $flash[$name][self::ACTIVE]   = true;
        $flash[$name][self::VARIABLE] = $value;

        $this->set(self::FLASH, $flash);

        return $this;
    }
}
