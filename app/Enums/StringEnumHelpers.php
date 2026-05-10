<?php

namespace App\Enums;

use Illuminate\Support\Collection;

trait StringEnumHelpers
{
    abstract public function getName(): string;

    /**
     * @return Collection<int, self>
     */
    public static function collect(): Collection
    {
        /* @phpstan-ignore-next-line return.type */
        return collect(static::cases());
    }

    /**
     * @return array<int, mixed>
     */
    public static function values(): array
    {
        return static::collect()->map(fn (self $type) => $type->value)->toArray();
    }

    /**
     * @return array<int, string>
     */
    public static function names(): array
    {
        return static::collect()->map(fn (self $type) => $type->getName())->toArray();
    }
}
