<?php

declare(strict_types=1);

namespace Freyr\RPA\Shared;

abstract class Event
{

    public static function name(): string
    {
        return static::$name;
    }

    public function getName(): string
    {
        return static::$name;
    }
}
