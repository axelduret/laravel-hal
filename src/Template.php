<?php

declare(strict_types=1);

namespace ApiSkeletons\Laravel\HAL;

use function array_keys;
use function in_array;
use function is_array;

class Template
{
    /**
     * @var array<string> $properties
     */
    private array $properties = [
        'contentType',
        'method',
        'properties',
        'target',
        'title',
    ];

    protected string $reference;

    /** @var array<mixed> $definition */
    protected array $definition;

    /** @param mixed $definition */
    public function __construct(string $reference, $definition)
    {
        $this->setReference($reference);
        $this->setDefinition($definition);
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    protected function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /** @return mixed */
    public function getDefinition()
    {
        return $this->definition;
    }

    /** @param mixed $definition */
    protected function setDefinition($definition): self
    {
        if (! is_array($definition)) {
            throw new Exception\InvalidProperty('Definition must be an array');
        }

        if (! in_array('method', array_keys($definition))) {
            throw new Exception\InvalidProperty("'method' is required");
        }

        foreach ($definition as $property => $value) {
            if (! in_array($property, $this->properties)) {
                throw new Exception\InvalidProperty("'" . $property . "' is an invalid property name");
            }

            if ($property === 'properties' && ! is_array($value)) {
                throw new Exception\InvalidProperty('Properties must be an array');
            }

            $this->definition[$property] = $value;
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->definition;
    }
}