<?php

declare(strict_types=1);

namespace Clairveillance\Laravel\HAL\Contracts;

use Clairveillance\Laravel\HAL\Resource;

interface HydratorContract
{
    /** @param mixed $class */
    public function extract($class): Resource;
}
