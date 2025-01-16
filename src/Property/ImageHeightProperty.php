<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class ImageHeightProperty extends AbstractProperty
{
    public static function getIdentifier(): string
    {
        return 'og:image:height';
    }
}
