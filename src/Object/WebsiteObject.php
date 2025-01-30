<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

/**
 * @link https://ogp.me/#type_website
 */
final readonly class WebsiteObject extends AbstractObject
{
    public static function getType(): string
    {
        return 'website';
    }
}
