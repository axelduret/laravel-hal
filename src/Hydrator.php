<?php

declare(strict_types=1);

namespace Clairveillance\Laravel\HAL;

use Clairveillance\Laravel\HAL\Contracts\HydratorContract;
use Clairveillance\Laravel\HAL\Contracts\HydratorManagerContract;

abstract class Hydrator implements HydratorContract
{
    protected HydratorManagerContract $hydratorManager;

    public function setHydratorManager(HydratorManagerContract $hydratorManager): self
    {
        $this->hydratorManager = $hydratorManager;

        return $this;
    }
}
