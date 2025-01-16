<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\TypeProperty;

final readonly class WebsiteObject extends AbstractObject
{
    protected function getType(): TypeProperty
    {
        return TypeProperty::website();
    }
}
