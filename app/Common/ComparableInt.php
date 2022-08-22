<?php

declare(strict_types=1);

namespace App\Common;

trait ComparableInt
{
    public function isSame($target): bool
    {
        if ($target instanceof self) {
            return false;
        }

        if (!property_exists($target, 'value')) {
            return false;
        }

        return $this->value === $target->value;
    }

    final private function __construct(
        private int $value,
    ) {
    }
}
