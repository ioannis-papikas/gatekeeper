<?php

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
