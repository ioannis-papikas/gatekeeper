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

use Gatekeeper\Handler\HandlerInterface;
use LogicException;

/**
 * Gate Keeper main handler
 *
 * It contains a stack of Handlers and uses them to check
 * if a given gate is open or not.
 */
class Keeper
{
    /**
     * The handler stack
     *
     * @var HandlerInterface[]
     */
    protected $handlers;

    /**
     * Keeper constructor.
     *
     * @param HandlerInterface[] $handlers Optional stack of handlers, the first one in the array is called first, etc.
     */
    public function __construct(array $handlers = [])
    {
        $this->handlers = $handlers;
    }

    /**
     * Use the handlers' stack to check whether the given gate is open for this execution thread
     *
     * @param string $gateName
     *
     * @return bool
     */
    public function checkGate(string $gateName): bool
    {
        // Go through all the handlers
        while ($handler = current($this->handlers)) {
            if ($handler->handle($gateName) === false) {
                return false;
            }
            next($this->handlers);
        }

        return true;
    }

    /**
     * Pushes a handler on to the stack.
     *
     * @param  HandlerInterface $handler
     *
     * @return $this
     */
    public function pushHandler(HandlerInterface $handler)
    {
        array_unshift($this->handlers, $handler);

        return $this;
    }

    /**
     * Pops a handler from the stack
     *
     * @return HandlerInterface
     */
    public function popHandler()
    {
        if (!$this->handlers) {
            throw new LogicException('You tried to pop from an empty handler stack.');
        }

        return array_shift($this->handlers);
    }

    /**
     * Set handlers, replacing all existing ones.
     *
     * If a map is passed, keys will be ignored.
     *
     * @param  HandlerInterface[] $handlers
     *
     * @return $this
     */
    public function setHandlers(array $handlers)
    {
        $this->handlers = array();
        foreach (array_reverse($handlers) as $handler) {
            $this->pushHandler($handler);
        }

        return $this;
    }

    /**
     * @return HandlerInterface[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }
}
