<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

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

    /**
     * @return string[]
     */
    abstract public static function getIdentifiers(): array;

    public static function getIdentifier(): string
    {
        return (string) current(static::getIdentifiers());
    }
}
