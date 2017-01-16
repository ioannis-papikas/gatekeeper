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

/**
 * Class IpAddressKeeper
 * Checks the request ip against allowed ips, blocked ips and sub networks
 *
 * @package Gatekeeper\Keeper
 */
class IpAddressKeeper extends AbstractKeeper
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var array
     */
    private $allowedIps;

    /**
     * @var array
     */
    private $blockedIps;

    /**
     * IpAddressKeeper constructor.
     *
     * @param Request $request
     * @param array   $allowedIps
     * @param array   $blockedIps
     */
    public function __construct(Request $request, array $allowedIps = [], array $blockedIps = [])
    {
        $this->request = $request;
        $this->allowedIps = $allowedIps;
        $this->blockedIps = $blockedIps;
    }

    /**
     * {@inheritdoc}
     */
    public function allow()
    {
        // Get current host ip
        $currentIp = $this->request->server->get('SERVER_ADDR');
        if (empty($currentIp)) {
            return false;
        }

        // Check if ip is in allowed ips
        if (in_array($currentIp, $this->allowedIps)) {
            return true;
        }
        // Check for sub-networks
        foreach ($this->allowedIps as $allowedIp) {
            if ($this->inSubnet($currentIp, $allowedIp)) {
                return true;
            }
        }

        // Check if ip is in blocked ips
        if (in_array($currentIp, $this->blockedIps)) {
            return false;
        }
        // Check for sub-networks
        foreach ($this->blockedIps as $blockedIp) {
            if ($this->inSubnet($currentIp, $blockedIp)) {
                return false;
            }
        }

        // If the ip doesn't match anything, block it
        return false;
    }

    /**
     * Check if a given ip is in a given subnet
     *
     * @param string $ip
     * @param string $subnet
     *
     * @return bool
     */
    private function inSubnet($ip, $subnet)
    {
        // Check direct equality
        if (trim($ip) === trim($subnet)) {
            return true;
        }

        return false;
    }
}
