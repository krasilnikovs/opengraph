<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class UrlProperty extends AbstractProperty
{
    public static function getName(): string
    {
        return 'og:url';
    }
}
