# GateKeeper
GateKeeper allows you to hide part of your product and make it active under given circumstances.

## Using GateKeeper
Gatekeeper works with **gates** and with **keepers**.

**Gates** are special software doors that should allow the execution flow when they are open and deny (or do something else) when they are closed. They have a name and a set of keepers.

**Keepers** are a number of conditions on every gate that decide whether the gate will open or close. On this approach, in order for the gate to open, all the keepers must “allow access”.

### How To
GateKeeper library consists of two parts, the initialization and the gate check.

The initialization should usually happen when the application starts, so it can be part of the application bootstrap:

**Initialization**
```
<?php

use Gatekeeper\Gate;
use Gatekeeper\GateKeeper;
use Gatekeeper\GateRegistry;
use Gatekeeper\Keeper\DateTimeKeeper;
use Gatekeeper\Keeper\IpAddressKeeper;

// Get / Mock (Symfony) Request object
$request = new \Symfony\Component\HttpFoundation\Request();

// Initialize a gate registry
$registry = new GateRegistry();

// Create a gate that will be activated only for January 2017
$keeper = new DateTimeKeeper(new \DateTime('2017-01-01'), new \DateTime('2017-02-01'));
$gate = new Gate('January-Feature', $keeper);
$registry->register($gate);

// Create a gate that will allow access only from a specific sub-network
$keeper = new IpAddressKeeper($request, ['10.1.1.0/24'], ['20.0.1.0/24']);
$gate = new Gate('Ip-Specific-Feature', $keeper);
$registry->register($gate);

// Setup GateKeeper and set to a container (or create a singleton)
$gateKeeper = new GateKeeper($registry);
$container->set(GateKeeper::class, $gateKeeper);
```

**Gate Check**
```
<?php

// At any point in our code, we can simply get the GateKeeper and check any gate
// Using a container (like PHP-DI) or a singleton that we have already created
$gateKeeper = $container->get(GateKeeper::class);

// Check gate
if ($gateKeeper->checkGate('January-Feature')) {
    // Gate is open
    echo 'gate is open';
} else {
    // Gate is closed
    echo 'gate is closed';
}
```
