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

use DateTime;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class DateTimeKeeperTest
 * @package Gatekeeper\Keeper
 */
class DateTimeKeeperTest extends KeeperTest
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        // Create keeper
        $this->setKeeper(new DateTimeKeeper());

        // Setup
        parent::setUp();
    }

    /**
     * @covers \Gatekeeper\Keeper\DateTimeKeeper::allow
     */
    public function testAllow()
    {
        /** @var DateTimeKeeper $keeper */
        $keeper = $this->getKeeper();

        // Test no limits, with current time (any)
        $this->assertTrue($keeper->allow());

        // Set global now
        $keeper->setNow(new DateTime('2017-02-10'));

        // Set only specific date
        $this->assertTrue($keeper->allow());

        // Set after parameter
        $keeper->setBefore(null);
        $keeper->setAfter(new DateTime('2017-02-10'));
        $this->assertTrue($keeper->allow());
        // --
        $keeper->setAfter(new DateTime('2017-02-01'));
        $this->assertTrue($keeper->allow());
        // --
        $keeper->setAfter(new DateTime('2017-02-20'));
        $this->assertFalse($keeper->allow());

        // Set before parameter
        $keeper->setAfter(null);
        $keeper->setBefore(new DateTime('2017-02-20'));
        $this->assertTrue($keeper->allow());
        // --
        $keeper->setBefore(new DateTime('2017-02-10'));
        $this->assertFalse($keeper->allow());
        // --
        $keeper->setBefore(new DateTime('2017-02-01'));
        $this->assertFalse($keeper->allow());

        // Set before and after
        $keeper->setAfter(new DateTime('2017-02-01'));
        $keeper->setBefore(new DateTime('2017-02-20'));
        $this->assertTrue($keeper->allow());
        // --
        $keeper->setAfter(new DateTime('2017-02-20'));
        $keeper->setBefore(new DateTime('2017-02-01'));
        $this->assertFalse($keeper->allow());
    }
}
