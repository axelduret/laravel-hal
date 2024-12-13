<?php

declare(strict_types=1);

namespace ApiSkeletons\Laravel\HAL;

use function array_keys;
use function in_array;
use function is_array;

class Property
{
    /**
     * @var array<string> $coreAttributes
     */
    private array $coreAttributes = [
        'name',
        'prompt',
        'readOnly',
        'regex',
        'required',
        'templated',
        'value',
    ];

    /**
     * @var array<string> $additionalAttributes
     */
    private array $additionalAttributes = [
        'cols',
        'max',
        'maxLength',
        'min',
        'minLength',
        'options',
        'placeholder',
        'rows',
        'step',
        'type',
    ];

    /** @var array<mixed> $definition */
    protected array $definition;

    /** @var Options|null $options */
    protected ?Option $options = null;

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
        if (! in_array('name', array_keys($definition))) {
            throw new Exception\InvalidProperty("'name' is required");
        }

        foreach ($definition as $property => $value) {
            if (! in_array($property, array_merge($this->coreAttributes, $this->additionalAttributes))) {
                throw new Exception\InvalidProperty("'" . $property . "' is an invalid property name");
            }

            if ($property === 'options' && is_array($value)) {
                $this->options = new Option($value);
            } else {
                $this->definition[$property] = $value;
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        $definition = $this->definition;

        if ($this->options) {
            $definition['options'] = $this->options->toArray();
        }

        return $definition;
    }
}