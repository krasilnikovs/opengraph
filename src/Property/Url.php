<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;
use Stringable;

final readonly class Url implements Stringable
{
    public string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
