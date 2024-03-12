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

/**
 * Class SessionTest
 *
 * @author Romain Cottard
 */
class SessionTest extends TestCase
{
    /**
     * @return void
     */
    public function testICanInitializeSessionService(): void
    {
        $session = new Session();

        $this->assertInstanceOf(Session::class, $session);
    }

    /**
     * @return void
     */
    public function testICanSetAndRetrieveValueInSession(): void
    {
        $session = new Session();

        $this->assertFalse($session->has('foo'));

        $session->set('foo', 'bar');
        $this->assertTrue($session->has('foo'));
        $this->assertEquals('bar', $session->get('foo'));
        $this->assertEquals('baz', $session->get('foz', 'baz'));

        $session->remove('foo');
        $this->assertFalse($session->has('foo'));
    }

    /**
     * @return void
     */
    public function testICanSetAndRetrieveEphemeralValueInSession(): void
    {
        $session = new Session();

        $this->assertFalse($session->hasFlash('foo'));

        $session->setFlash('foo', 'bar');
        $this->assertTrue($session->hasFlash('foo'));
        $this->assertEquals('bar', $session->getFlash('foo'));
        $this->assertEquals('baz', $session->getFlash('foz', 'baz'));

        $session->clearFlash();
        $session->clearFlash();
    }

    /**
     * @return void
     */
    public function testICanCleanEphemeralValueInSession(): void
    {
        $_SESSION = [];

        $session = new Session();

        $session->setFlash('foo', 'bar');

        //~ First call render ephemeral "not active" (= removed after the second call)
        $session->clearFlash();
        $this->assertTrue($session->hasFlash('foo'));

        //~ First call render ephemeral "not active" (= removed after the second call)
        $session->clearFlash();
        $this->assertFalse($session->hasFlash('foo'));
    }
}
