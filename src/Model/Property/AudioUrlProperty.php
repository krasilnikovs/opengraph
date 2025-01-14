<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class AudioUrlProperty extends AbstractProperty
{
    public static function getIdentifiers(): array
    {
        return ['og:audio', 'og:audio:url'];
    }
}
