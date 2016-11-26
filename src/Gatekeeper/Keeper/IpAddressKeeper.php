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
 * Class AbstractKeeper. Base Keeper for providing basic support and guidelines
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
    public function __construct(Request $request, $allowedIps = [], $blockedIps = [])
    {
        $this->request = $request;
        $this->allowedIps = $allowedIps;
        $this->blockedIps = $blockedIps;
    }

    /**
     * {@inheritdoc}
     */
    public function allow($gateName)
    {
        // Get current host ip
        $currentIp = $this->request->server->get('SERVER_ADDR', '');

        // Check if ip is in allowed ips
        if (in_array($currentIp, $this->allowedIps)) {
            return true;
        }
        // Check for sub-networks
        foreach ($this->allowedIps as $allowedIp) {

        }

        // Check if ip is in blocked ips
        if (in_array($currentIp, $this->blockedIps)) {
            return false;
        }
        // Check for sub-networks
        foreach ($this->blockedIps as $blockedIp) {

        }

        return true;
    }
}
