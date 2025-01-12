<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;


final readonly class UrlProperty extends AbstractProperty
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

    public static function getName(): string
    {
        return 'og:url';
    }
}
