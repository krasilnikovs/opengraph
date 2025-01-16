<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;

abstract readonly class AbstractBaseObject
{
    public TypeProperty $type;
    public UrlProperty $url;
    public TitleProperty $title;
    public ImagePropertyCollection $images;

    public function __construct(
        UrlProperty             $url,
        TitleProperty           $title,
        ImagePropertyCollection $images,
    ) {
        $this->type = $this->getType();
        $this->url  = $url;
        $this->title = $title;
        $this->images = $images;
    }

    abstract protected function getType(): TypeProperty;
}
