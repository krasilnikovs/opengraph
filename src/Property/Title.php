<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class Title
{
    public string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): Title
    {
        return new self($value);
    }
}
