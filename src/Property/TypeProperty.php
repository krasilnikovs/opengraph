<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class TypeProperty extends AbstractProperty
{
    public const string WEBSITE = 'website';

    public string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function website(): self
    {
        return new self(self::WEBSITE);
    }

    public static function custom(string $value): self
    {
        return new self($value);
    }

    public static function getName(): string
    {
        return 'og:type';
    }
}
