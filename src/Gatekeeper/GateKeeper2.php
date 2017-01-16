<?php

/*
 * This file is part of the Gatekeeper package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gatekeeper;

/**
 * Class GateKeeper
 * Given a gate registry, determine if a given gate is open or not.
 *
 * @package Gatekeeper
 */
class GateKeeper2
{
    /**
     * @var GateRegistry
     */
    protected $registry;

    /**
     * GateKeeper constructor.
     *
     * @param GateRegistry $registry
     */
    public function __construct(GateRegistry $registry)
    {
        $this->setRegistry($registry);
    }

    /**
     * Use the keepers' stack to check whether the given gate is open for this execution thread
     *
     * @param string $gateName
     *
     * @return bool
     */
    public function checkGate(string $gateName)
    {
        // Get gate
        $gate = $this->registry->getGate($gateName);

        return $gate->check();
    }

    /**
     * @param GateRegistry $registry
     *
     * @return GateKeeper
     */
    public function setRegistry(GateRegistry $registry)
    {
        $this->registry = $registry;

        return $this;
    }

    /**
     * @return GateRegistry
     */
    public function getRegistry()
    {
        return $this->registry;
    }
}
