<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class SiteNameProperty extends AbstractProperty
{
    public static function getName(): string
    {
        return 'og:site_name';
    }
}
