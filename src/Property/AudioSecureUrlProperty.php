<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class AudioSecureUrlProperty extends AbstractProperty
{
    public static function getIdentifier(): string
    {
        return 'og:audio:secure_url';
    }
}
