<?php

declare(strict_types=1);

namespace Freyr\RPA\Shared\Specification;

class OrSpecification extends Specification
{
    private Specification $one;

    private Specification $other;

    public function __construct(Specification $one, Specification $other)
    {
        $this->one   = $one;
        $this->other = $other;
    }

    public function isSatisfiedBy($object): bool
    {
        return $this->one->isSatisfiedBy($object) || $this->other->isSatisfiedBy($object);
    }
}
