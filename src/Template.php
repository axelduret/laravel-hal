<?php

declare(strict_types=1);

namespace ApiSkeletons\Laravel\HAL;

use ApiSkeletons\Laravel\HAL\Enum\HttpMethods;

use function array_keys;
use function in_array;
use function is_array;

final class Template
{
    /**
     * See https://rwcbook.github.io/hal-forms
     * 
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

    /** @var Property[] $properties */
    protected array $propertiesList = [];

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
        if (!is_array($definition)) {
            throw new Exception\InvalidProperty('Definition must be an array');
        }

        if (!in_array('method', array_keys($definition))) {
            throw new Exception\InvalidProperty("'method' is required");
        }

        $validMethods = array_map(fn ($method) => $method->value, HttpMethods::cases());

        if (!in_array($definition['method'], HttpMethods::cases())) {
            throw new Exception\InvalidProperty(sprintf("'method' must be one of %s", implode(', ', $validMethods)));
        }

        foreach ($definition as $property => $value) {
            if (!in_array($property, $this->properties)) {
                throw new Exception\InvalidProperty("'" . $property . "' is an invalid property name");
            }

            if($property === 'method'){
                if(!in_array($value, HttpMethods::cases())){
                    throw new Exception\InvalidProperty(sprintf("'method' must be one of %s", implode(', ', HttpMethods::cases())));
                }
                $value = $value->value;
            }

            if ($property === 'properties' && is_array($value)) {
                foreach ($value as $prop) {
                    $this->propertiesList[] = new Property($prop);
                }
            } else {
                $this->definition[$property] = $value;
            }
        }

        if (!empty($this->propertiesList)) {
            $this->definition['properties'] = array_map(function ($property) {
                return $property->toArray();
            }, $this->propertiesList);
        }

        return $this;
    }
}