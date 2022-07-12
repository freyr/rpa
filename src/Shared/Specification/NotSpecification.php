<?php

declare(strict_types=1);

namespace Freyr\RPA\Shared\Specification;

class NotSpecification extends Specification
{
    private Specification $specification;

    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

    public function isSatisfiedBy($object): bool
    {
        return !$this->specification->isSatisfiedBy($object);
    }
}
