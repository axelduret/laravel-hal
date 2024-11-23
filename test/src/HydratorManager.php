<?php

declare(strict_types=1);

namespace ClairveillanceTest\Laravel\HAL;

use Clairveillance\Laravel\HAL\HydratorManager as HalHydratorManager;

final class HydratorManager extends HalHydratorManager
{
    /** {@inheritdoc} */
    protected array $classHydrators = [
        Model\User::class => Hydrator\UserHydrator::class,
    ];
}
