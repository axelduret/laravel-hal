<?php

declare(strict_types=1);

namespace ApiSkeletons\Laravel\HAL;

use function array_keys;
use function in_array;
use function is_array;

final class Option
{
    /**
     * @var array<string> $attributes
     */
    private array $attributes = [
        'inline',
        'link',
        'maxItems',
        'minItems',
        'promptField',
        'selectedValues',
    ];

    /** @var array<mixed> $definition */
    protected array $definition;

    /** @param mixed $definition */
    public function __construct(array $definition)
    {
        $this->setDefinition($definition);
    }

    /** @return mixed */
    public function getDefinition()
    {
        return $this->definition;
    }

    /** @param mixed $definition */
    protected function setDefinition(array $definition): self
    {
        foreach ($definition as $attribute => $value) {
            if (! in_array($attribute, $this->attributes)) {
                throw new Exception\InvalidProperty("'" . $attribute . "' is an invalid attribute name");
            }

            if ($attribute === 'link' && ! is_array($value)) {
                throw new Exception\InvalidProperty('Link must be an array');
            }

            $this->definition[$attribute] = $value;
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->definition;
    }
}