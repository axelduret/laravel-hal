<?php

declare(strict_types=1);

namespace ClairveillanceTest\Laravel\HAL\Hydrator;

use Clairveillance\Laravel\HAL\Hydrator;
use Clairveillance\Laravel\HAL\Resource;
use Illuminate\Foundation\Application;

use function get_class;

final class DiHydrator extends Hydrator
{
    private Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** {@inheritdoc} */
    public function extract($class): Resource
    {
        $data = [
            'app' => get_class($this->app),
        ];

        return $this->hydratorManager->resource($data);
    }
}
