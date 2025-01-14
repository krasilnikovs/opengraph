<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class ImageTypeProperty extends AbstractProperty
{
    public static function getIdentifier(): string
    {
        return 'og:image:type';
    }
}
