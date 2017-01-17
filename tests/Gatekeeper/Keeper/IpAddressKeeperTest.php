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

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class IpAddressKeeperTest
 * @package Gatekeeper\Keeper
 */
class IpAddressKeeperTest extends KeeperTest
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        // Create keeper
        $this->setKeeper(new IpAddressKeeper());

        // Setup
        parent::setUp();
    }

    /**
     * @covers \Gatekeeper\Keeper\IpAddressKeeper::allow
     */
    public function testAllow()
    {
        /** @var IpAddressKeeper $keeper */
        $keeper = $this->getKeeper();

        // Set dummy request
        $request = new Request([], [], [], [], [], ['SERVER_ADDR' => '1.1.1.1']);
        $keeper->setRequest($request);

        // Check default behavior
        $this->assertTrue($keeper->allow());

        // Set allowed IPs
        $keeper->setAllowedIps(['1.1.1.1']);
        $this->assertTrue($keeper->allow());
        // --
        $keeper->setAllowedIps(['1.1.1.2']);
        $this->assertFalse($keeper->allow());

        // Set blocked IPs
        $keeper->setAllowedIps([]);
        $keeper->setBlockedIps(['1.1.1.1']);
        $this->assertFalse($keeper->allow());
        // --
        $keeper->setBlockedIps(['1.1.1.2']);
        $this->assertTrue($keeper->allow());

        // Set both allowed and blocked IPs
        $keeper->setAllowedIps(['1.1.1.1']);
        $keeper->setBlockedIps(['1.1.1.2']);
        $this->assertTrue($keeper->allow());
        // --
        $keeper->setAllowedIps(['1.1.1.2']);
        $keeper->setBlockedIps(['1.1.1.1']);
        $this->assertFalse($keeper->allow());
    }
}
