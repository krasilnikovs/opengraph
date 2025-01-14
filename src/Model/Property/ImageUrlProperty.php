<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class ImageUrlProperty extends AbstractProperty
{
    public static function getIdentifiers(): array
    {
        return ['og:image', 'og:image:url'];
    }
}
