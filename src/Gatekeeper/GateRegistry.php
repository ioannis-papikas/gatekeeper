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

use InvalidArgumentException;
use LogicException;

/**
 * Class GateRegistry
 * Registers all gates for global use.
 *
 * @package Gatekeeper
 */
class GateRegistry
{
    /**
     * All the registered gates in the registry
     *
     * @var Gate[]
     */
    protected $gates;

    /**
     * Register a gate to the registry
     *
     * @param Gate $gate
     */
    public function register(Gate $gate)
    {
        // Check arguments
        if (empty($gate) || !($gate instanceof Gate)) {
            throw new InvalidArgumentException('The given gate is invalid.');
        }

        // Check if gate already exists
        if (empty($this->getGate($gate->getName()))) {
            throw new LogicException('There is already a gate with the same name.');
        }

        $this->pushGate($gate);
    }

    /**
     * Pushes a gate on to the stack.
     *
     * @param Gate $gate
     *
     * @return $this
     */
    public function pushGate(Gate $gate)
    {
        array_unshift($this->gates, $gate);

        return $this;
    }

    /**
     * Pops a gate from the stack
     *
     * @return Gate
     */
    public function popGate()
    {
        if (empty($this->gates)) {
            throw new LogicException('You tried to pop from an empty handler stack.');
        }

        return array_shift($this->gates);
    }

    /**
     * @param Gate[] $gates
     *
     * @return GateRegistry
     */
    public function setGates(array $gates)
    {
        $this->gates = $gates;

        return $this;
    }

    /**
     * @return Gate[]
     */
    public function getGates()
    {
        return $this->gates;
    }

    /**
     * Get a gate from the stack.
     * If the gate doesn't exist, returns null.
     *
     * @param string $name The gate name
     *
     * @return Gate|null
     */
    public function getGate($name)
    {
        return isset($this->getGates()[$name]) ? $this->getGates()[$name] : null;
    }
}
