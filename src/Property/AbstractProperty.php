<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

abstract readonly class AbstractProperty
{
    public string $content;

    protected function __construct(string $content)
    {
        $this->content = $content;
    }

    public static function fromString(string $content): static
    {
        return new static($content);
    }

    public static function empty(): static
    {
        return static::fromString('');
    }

    abstract public static function getName(): string;
}
