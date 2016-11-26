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
 * Class AbstractKeeper. Base Keeper for providing basic support and guidelines
 * @package Gatekeeper\Keeper
 */
abstract class AbstractKeeper implements KeeperInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function allow($gateName);
}
