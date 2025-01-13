<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Model\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Model\Property\TitleProperty;
use Krasilnikovs\Opengraph\Model\Property\TypeProperty;
use Krasilnikovs\Opengraph\Model\Property\UrlProperty;

final readonly class WebsiteObject extends AbstractBaseObject
{
    public function __construct(
        UrlProperty             $url,
        TitleProperty           $title,
        ImagePropertyCollection $images,
    ) {
        parent::__construct($url, $title, $images);
    }

    protected function getType(): TypeProperty
    {
        return TypeProperty::website();
    }
}
