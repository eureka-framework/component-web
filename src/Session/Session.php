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
 *
 * @author Romain Cottard
 */
class Session
{
    /** @var string FLASH Session index name for ephemeral var in Session. */
    private const FLASH = '_flash';

    /** @var string ACTIVE Session index name for ephemeral var if active or not. */
    private const ACTIVE = 'active';

    /** @var string VARIABLE Session index name for ephemeral var content. */
    private const VARIABLE = 'var';

    /** @var array<mixed>|null $session */
    protected static ?array $session = null;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @return void
     */
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
     *
     * @param  string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset(self::$session[$key]);
    }

    /**
     * Get session value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return self::$session[$key] ?? $default;
    }

    /**
     * Set value for a given key.
     *
     * @param  string $key
     * @param  mixed $value
     * @return self
     */
    public function set(string $key, $value): self
    {
        self::$session[$key] = $value;

        return $this;
    }

    /**
     * Remove key from bag container.
     * If key not exists, must throw an BagKeyNotFoundException
     *
     * @param  string $key
     * @return static
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
     *
     * @param string $name
     * @param mixed|null $default
     * @return mixed  Variable value.
     */
    public function getFlash(string $name, $default = null)
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
     *
     * @param  string $name Index Session name.
     * @return bool
     */
    public function hasFlash(string $name): bool
    {
        /** @var array<mixed> $flash */
        $flash = $this->get(self::FLASH);

        return isset($flash[$name]);
    }

    /**
     * Initialize Session. Remove old ephemeral var in Session.
     *
     * @return $this
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
     *
     * @param  string $name
     * @param  mixed $value
     * @return $this
     */
    public function setFlash(string $name, $value): self
    {
        /** @var array<array<mixed>> $flash */
        $flash = $this->get(self::FLASH);

        $flash[$name][self::ACTIVE]   = true;
        $flash[$name][self::VARIABLE] = $value;

        $this->set(self::FLASH, $flash);

        return $this;
    }
}
