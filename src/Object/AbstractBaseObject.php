<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Model\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Model\Property\TitleProperty;
use Krasilnikovs\Opengraph\Model\Property\TypeProperty;
use Krasilnikovs\Opengraph\Model\Property\UrlProperty;

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
