<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class ImageUrlProperty extends AbstractProperty
{
    public static function getName(): string
    {
        return 'og:image:url';
    }
}
