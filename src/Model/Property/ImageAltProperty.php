<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class ImageAltProperty extends AbstractProperty
{
    public static function getIdentifiers(): array
    {
        return ['og:image:alt'];
    }
}
