<?php

declare(strict_types=1);

namespace Freyr\RPA\Shared\Specification;

abstract class Specification
{
    abstract public function isSatisfiedBy($object): bool;

    public function and(Specification $specification): AndSpecification
    {
        return new AndSpecification($this, $specification);
    }

    public function or(Specification $specification): OrSpecification
    {
        return new OrSpecification($this, $specification);
    }

    public function not(): NotSpecification
    {
        return new NotSpecification($this);
    }
}
