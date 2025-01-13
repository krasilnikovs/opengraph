<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

abstract readonly class AbstractProperty
{
    /**
     * @return string[]
     */
    abstract public static function getIdentifiers(): array;

    public static function getIdentifier(): string
    {
        return (string) current(static::getIdentifiers());
    }
}
