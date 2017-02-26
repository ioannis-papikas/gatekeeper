<?php

/*
 * This file is part of the Gatekeeper package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gatekeeper\Keeper;

class DummyKeeperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Gatekeeper\Keeper\DummyKeeper::allow
     */
    public function testAllow()
    {
        $keeper = new DummyKeeper();

        $keeper->setAllow(true);
        $this->assertTrue($keeper->allow());

        $keeper->setAllow(false);
        $this->assertFalse($keeper->allow());
    }
}
