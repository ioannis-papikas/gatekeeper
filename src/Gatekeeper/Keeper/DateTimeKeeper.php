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

use DateTime;

/**
 * Class DateTimeKeeper
 *
 * Set before and after dates as boundaries for the keeper to open or remain closed. Examples:
 * 1. Enable a feature after a specific date, set $after variable
 * 2. Enable a feature until a specific date, set $before variable
 * 3. Enable a feature for a specific date span, set $after as the starting date and $before as the ending date
 *
 * @package Gatekeeper\Keeper
 */
class DateTimeKeeper extends AbstractKeeper
{
    /**
     * @var DateTime
     */
    private $after;

    /**
     * @var DateTime
     */
    private $before;

    /**
     * DateKeeper constructor.
     *
     * @param DateTime|null $after  Current date must be after this date (or equal) for the keeper to open
     * @param DateTime|null $before Current date must be before this date (or equal) for the keeper to open
     */
    public function __construct(DateTime $after = null, DateTime $before = null)
    {
        $this->after = $after;
        $this->before = $before;
    }

    /**
     * {@inheritdoc}
     */
    public function allow()
    {
        // Get current date
        $now = new DateTime();

        // Set before and after status
        $beforeStatus = empty($this->before) ? true : $now <= $this->before;
        $afterStatus = empty($this->after) ? true : $now >= $this->after;

        // Check if both conditions are met
        return $beforeStatus && $afterStatus;
    }

    /**
     * @return DateTime
     */
    public function getAfter()
    {
        return $this->after;
    }

    /**
     * @param DateTime $after
     */
    public function setAfter(DateTime $after)
    {
        $this->after = $after;
    }

    /**
     * @return DateTime
     */
    public function getBefore()
    {
        return $this->before;
    }

    /**
     * @param DateTime $before
     */
    public function setBefore(DateTime $before)
    {
        $this->before = $before;
    }
}
