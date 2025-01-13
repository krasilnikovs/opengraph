<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;

final readonly class WebsiteObject extends AbstractBaseObject
{
    public function __construct(UrlProperty $url, TitleProperty $title, ImagePropertyCollection $images)
    {
        parent::__construct($url, $title, $images);
    }

    protected function getType(): TypeProperty
    {
        return TypeProperty::website();
    }
}
