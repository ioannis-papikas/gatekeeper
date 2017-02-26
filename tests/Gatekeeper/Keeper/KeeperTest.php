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

require_once __DIR__ . '/../../bootstrap.php';

use PHPUnit_Framework_TestCase;

/**
 * Class KeeperTest
 * @package Gatekeeper
 */
abstract class KeeperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var KeeperInterface
     */
    protected $keeper;

    /**
     * @return KeeperInterface
     */
    public function getKeeper(): KeeperInterface
    {
        return $this->keeper;
    }

    /**
     * @param KeeperInterface $keeper
     */
    public function setKeeper(KeeperInterface $keeper)
    {
        $this->keeper = $keeper;
    }
}
