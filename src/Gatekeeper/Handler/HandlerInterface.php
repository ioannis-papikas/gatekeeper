<?php

/*
 * This file is part of the Gatekeeper package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gatekeeper\Handler;

/**
 * Interface HandlerInterface. All Gatekeeper handlers must implement
 * @package Gatekeeper\Handler
 */
interface HandlerInterface
{
    /**
     * @param string $gateName The gate name
     *
     * @return bool It returns true if the gate is open on behalf of this handler
     *              It returns false if the gate is not open on behalf of this handler and so it should not open at all
     */
    public function handle($gateName);
}
