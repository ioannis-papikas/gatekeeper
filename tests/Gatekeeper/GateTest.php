<?php

namespace Gatekeeper;

use Gatekeeper\Keeper\DummyKeeper;
use PHPUnit_Framework_TestCase;

class GateTest extends PHPUnit_Framework_TestCase
{
    public function testGateConditionAND()
    {
        // Set keepers
        $dummyKeeper1 = new DummyKeeper();
        $dummyKeeper2 = new DummyKeeper();

        // Setup Gate with CONDITION_AND
        $keepers = [$dummyKeeper1, $dummyKeeper2];
        $gate = new Gate('test-gate', $keepers, Gate::CONDITION_AND);

        // Assert
        $dummyKeeper1->setAllow(true);
        $dummyKeeper2->setAllow(true);
        $this->assertTrue($gate->check());

        // Assert
        $dummyKeeper1->setAllow(true);
        $dummyKeeper2->setAllow(false);
        $this->assertFalse($gate->check());

        $dummyKeeper1->setAllow(false);
        $dummyKeeper2->setAllow(true);
        $this->assertFalse($gate->check());

        $dummyKeeper1->setAllow(false);
        $dummyKeeper2->setAllow(false);
        $this->assertFalse($gate->check());
    }

    public function testGateConditionOR()
    {
        // Set keepers
        $dummyKeeper1 = new DummyKeeper();
        $dummyKeeper2 = new DummyKeeper();

        // Setup Gate with CONDITION_OR
        $keepers = [$dummyKeeper1, $dummyKeeper2];
        $gate = new Gate('test-gate', $keepers, Gate::CONDITION_OR);

        // Assert
        $dummyKeeper1->setAllow(true);
        $dummyKeeper2->setAllow(true);
        $this->assertTrue($gate->check());

        // Assert
        $dummyKeeper1->setAllow(true);
        $dummyKeeper2->setAllow(false);
        $this->assertTrue($gate->check());

        $dummyKeeper1->setAllow(false);
        $dummyKeeper2->setAllow(true);
        $this->assertTrue($gate->check());

        $dummyKeeper1->setAllow(false);
        $dummyKeeper2->setAllow(false);
        $this->assertFalse($gate->check());
    }
}
