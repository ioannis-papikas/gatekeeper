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
    const CONDITION_AND = 1;
    const CONDITION_OR = 2;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var KeeperInterface[]
     */
    protected $keepers;

    /**
     * @var int
     */
    protected $condition;

    /**
     * Keeper constructor.
     *
     * @param string            $name    The gate name. It's case insensitive.
     * @param KeeperInterface[] $keepers Gate keepers, the first one in the array is called first, etc.
     * @param int               $condition
     */
    public function __construct(string $name, array $keepers, $condition = self::CONDITION_AND)
    {
        $this->setName($name);
        $this->setKeepers($keepers);
        $this->setCondition($condition);
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

        // Set default status to true if no keepers available
        $defaultStatus = $this->getCondition() == self::CONDITION_AND || empty($keepers) ? true : false;

        // Go through all the handlers
        /** @var KeeperInterface $keeper */
        while ($keeper = current($keepers)) {
            if ($keeper->allow() === false && $this->getCondition() == self::CONDITION_AND) {
                return false;
            }
            if ($keeper->allow() === true && $this->getCondition() == self::CONDITION_OR) {
                return true;
            }
            next($keepers);
        }

        // Return gate default status
        return $defaultStatus;
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
     * @throws LogicException
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

    /**
     * @return int
     */
    public function getCondition(): int
    {
        return $this->condition;
    }

    /**
     * @param int $condition
     *
     * @return Gate
     */
    public function setCondition(int $condition): Gate
    {
        $this->condition = $condition;

        return $this;
    }
}
