<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class AudioTypeProperty extends AbstractProperty
{
    public static function getIdentifiers(): array
    {
        return ['og:audio:type'];
    }
}
