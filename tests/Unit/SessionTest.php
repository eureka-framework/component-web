<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Tests\Unit;

use Eureka\Component\Web\Session\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function testICanSetAndRetrieveValueInSession(): void
    {
        $session = new Session();

        self::assertFalse($session->has('foo'));

        $session->set('foo', 'bar');
        self::assertTrue($session->has('foo'));
        self::assertSame('bar', $session->get('foo'));
        self::assertSame('baz', $session->get('foz', 'baz'));

        $session->remove('foo');
        self::assertFalse($session->has('foo'));
    }

    public function testICanSetAndRetrieveEphemeralValueInSession(): void
    {
        $session = new Session();

        self::assertFalse($session->hasFlash('foo'));

        $session->setFlash('foo', 'bar');
        self::assertTrue($session->hasFlash('foo'));
        self::assertSame('bar', $session->getFlash('foo'));
        self::assertSame('baz', $session->getFlash('foz', 'baz'));

        $session->clearFlash();
        $session->clearFlash();
    }

    public function testICanCleanEphemeralValueInSession(): void
    {
        $_SESSION = [];

        $session = new Session();

        $session->setFlash('foo', 'bar');

        //~ First call render ephemeral "not active" (= removed after the second call)
        $session->clearFlash();
        self::assertTrue($session->hasFlash('foo'));

        //~ First call render ephemeral "not active" (= removed after the second call)
        $session->clearFlash();
        self::assertFalse($session->hasFlash('foo'));
    }
}
