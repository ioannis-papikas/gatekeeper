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

use Gatekeeper\Keeper\KeeperInterface;
use LogicException;

/**
 * Class Gate
 * @package Gatekeeper
 */
class Gate
{
    /**
     * @var string
     */
    protected $name;

    /**
     * The gates' keeper stack
     *
     * @var KeeperInterface[]
     */
    protected $keepers;

    /**
     * Keeper constructor.
     *
     * @param string            $name    The gate name. It's case insensitive.
     * @param KeeperInterface[] $keepers Gate keepers, the first one in the array is called first, etc.
     */
    public function __construct(string $name, array $keepers)
    {
        $this->setName($name);
        $this->setKeepers($keepers);
    }

    /**
     * Check if the gate is open based on its keepers.
     *
     * @return bool
     */
    public function check()
    {
        // Get all gate keepers
        $keepers = $this->getKeepers();

        // Go through all the handlers
        /** @var KeeperInterface $keeper */
        while ($keeper = current($keepers)) {
            if ($keeper->allow() === false) {
                return false;
            }
            next($keepers);
        }

        // No keeper is closed, gate is open
        return true;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = strtolower($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Pushes a keeper on to the stack.
     *
     * @param KeeperInterface $keeper
     *
     * @return $this
     */
    public function pushKeeper(KeeperInterface $keeper)
    {
        array_unshift($this->keepers, $keeper);

        return $this;
    }

    /**
     * Pops a keeper from the stack
     *
     * @return KeeperInterface
     */
    public function popKeeper()
    {
        if (!$this->keepers) {
            throw new LogicException('You tried to pop from an empty handler stack.');
        }

        return array_shift($this->keepers);
    }

    /**
     * Set keepers, replacing all existing ones.
     *
     * If a map is passed, keys will be ignored.
     *
     * @param KeeperInterface[] $keepers
     *
     * @return $this
     */
    public function setKeepers(array $keepers)
    {
        $this->keepers = [];
        foreach (array_reverse($keepers) as $keeper) {
            $this->pushKeeper($keeper);
        }

        return $this;
    }

    /**
     * @return KeeperInterface[]
     */
    public function getKeepers()
    {
        return $this->keepers;
    }
}
