<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Container;

/**
 * Marker for an Ahead-of-Time compiled service container (AOT-01).
 *
 * A compiled container is generated at build time from the fully-wired runtime
 * container: it instantiates non-synthetic services through hardcoded
 * constructor calls, bypassing runtime reflection for sub-millisecond cold
 * starts. It MUST produce a service graph identical to the runtime container
 * (verified by snapshot) and remains drop-in: the kernel falls back to the
 * reflection-based container when no compiled artifact is present or it fails to
 * load.
 *
 * Compiled containers delegate request-scoped {@see ContainerInterface::reset()}
 * to the same cascade as the runtime container, so no new cross-request state is
 * introduced by compilation.
 */
interface CompiledContainerInterface extends ContainerInterface {}
