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
 * Checks the request ip against allowed ips, blocked ips and sub networks.
 *
 * If allowed IPs are set, the given IP must match for the keeper to allow access to the gate.
 * If allowed IPs are not set, it will allow access unless the IP is in the blocked IPs.
 *
 * This version of IpAddressKeeper doesn't support sub-nets yet.
 *
 * @package Gatekeeper\Keeper
 */
class IpAddressKeeper extends AbstractKeeper
{
    /**
     * @var Request
     */
    private $request = null;

    /**
     * @var array
     */
    private $allowedIps = [];

    /**
     * @var array
     */
    private $blockedIps = [];

    /**
     * IpAddressKeeper constructor.
     *
     * @param Request $request
     * @param array   $allowedIps
     * @param array   $blockedIps
     */
    public function __construct(Request $request = null, array $allowedIps = [], array $blockedIps = [])
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
        // Check current request
        if (empty($this->getRequest())) {
            return false;
        }

        // Get current host IP
        $currentIp = $this->request->server->get('SERVER_ADDR');
        if (empty($currentIp)) {
            return false;
        }

        // Check if IP is in allowed IPs
        if (in_array($currentIp, $this->allowedIps)) {
            return true;
        }
        // Check for sub-networks
        foreach ($this->allowedIps as $allowedIp) {
            if ($this->inSubnet($currentIp, $allowedIp)) {
                return true;
            }
        }

        // If allowed IPs are not empty but no match, return false
        if (!empty($this->getAllowedIps())) {
            return false;
        }

        // Check if IP is in blocked IPs
        if (in_array($currentIp, $this->blockedIps)) {
            return false;
        }
        // Check for sub-networks
        foreach ($this->blockedIps as $blockedIp) {
            if ($this->inSubnet($currentIp, $blockedIp)) {
                return false;
            }
        }

        // No conditions are met, no allowed IPs are set and blocking IPs are not met
        // Default value is true
        return true;
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

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getAllowedIps(): array
    {
        return $this->allowedIps;
    }

    /**
     * @param array $allowedIps
     */
    public function setAllowedIps(array $allowedIps)
    {
        $this->allowedIps = $allowedIps;
    }

    /**
     * @return array
     */
    public function getBlockedIps(): array
    {
        return $this->blockedIps;
    }

    /**
     * @param array $blockedIps
     */
    public function setBlockedIps(array $blockedIps)
    {
        $this->blockedIps = $blockedIps;
    }
}
