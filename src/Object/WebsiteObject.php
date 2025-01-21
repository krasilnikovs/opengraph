<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

final readonly class WebsiteObject extends AbstractObject
{
    public static function getType(): string
    {
        return 'website';
    }
}
