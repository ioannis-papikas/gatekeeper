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

/**
 * Interface KeeperInterface. All Gate keepers must implement this interface
 * @package Gatekeeper\Keeper
 */
interface KeeperInterface
{
    /**
     * Check if the keeper allows gate passing or not.
     *
     * @return bool It returns true if the gate is open on behalf of this keeper or false otherwise.
     */
    public function allow();
}
