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
 * Class DummyKeeper
 * @package Gatekeeper\Keeper
 */
class DummyKeeper extends AbstractKeeper
{
    /**
     * @var bool
     */
    protected $allow;

    /**
     * {@inheritdoc}
     */
    public function allow()
    {
        return $this->allow;
    }

    /**
     * @return bool
     */
    public function isAllow(): bool
    {
        return $this->allow;
    }

    /**
     * @param bool $allow
     *
     * @return DummyKeeper
     */
    public function setAllow(bool $allow): DummyKeeper
    {
        $this->allow = $allow;

        return $this;
    }
}
