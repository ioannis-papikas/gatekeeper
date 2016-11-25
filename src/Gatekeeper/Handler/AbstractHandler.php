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
 * Class AbstractHandler. Base Keeper Handler for providing basic support and guidelines
 * @package Gatekeeper\Handler
 */
abstract class AbstractHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function handle($gateName);
}
