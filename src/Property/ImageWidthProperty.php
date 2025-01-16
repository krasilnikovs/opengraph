<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class ImageWidthProperty extends AbstractProperty
{
    public static function getName(): string
    {
        return 'og:image:width';
    }
}
