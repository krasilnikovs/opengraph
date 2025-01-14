<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class TypeProperty extends AbstractProperty
{
    private const string WEBSITE = 'website';

    public static function website(): self
    {
        return self::fromString(self::WEBSITE);
    }

    public static function getIdentifiers(): array
    {
        return ['og:type'];
    }

    public function isWebsite(): bool
    {
        return $this->content === self::WEBSITE;
    }
}
