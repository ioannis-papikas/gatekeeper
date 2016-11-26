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
 * Gate Keeper main handler
 *
 * It contains a stack of Handlers and uses them to check
 * if a given gate is open or not.
 */
class Gatekeeper
{
    /**
     * The keeper stack
     *
     * @var KeeperInterface[]
     */
    protected $keepers;

    /**
     * Keeper constructor.
     *
     * @param KeeperInterface[] $keepers Optional stack of keepers, the first one in the array is called first, etc.
     */
    public function __construct(array $keepers = [])
    {
        $this->keepers = $keepers;
    }

    /**
     * Use the keepers' stack to check whether the given gate is open for this execution thread
     *
     * @param string $gateName
     *
     * @return bool
     */
    public function checkGate(string $gateName): bool
    {
        // Go through all the handlers
        while ($keeper = current($this->keepers)) {
            if ($keeper->keep($gateName) === true) {
                return false;
            }
            next($this->keepers);
        }

        return true;
    }

    /**
     * Pushes a keeper on to the stack.
     *
     * @param  KeeperInterface $keeper
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
     * @param  KeeperInterface[] $keepers
     *
     * @return $this
     */
    public function setKeepers(array $keepers)
    {
        $this->keepers = array();
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
