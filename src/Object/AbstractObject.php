<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\DescriptionProperty;
use Krasilnikovs\Opengraph\Property\DeterminerProperty;
use Krasilnikovs\Opengraph\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;

abstract readonly class AbstractObject
{
    public TypeProperty $type;
    public UrlProperty $url;
    public TitleProperty $title;
    public ImagePropertyCollection $images;
    public DescriptionProperty $description;
    public DeterminerProperty $determiner;

    public function __construct(
        UrlProperty             $url,
        TitleProperty           $title,
        ImagePropertyCollection $images,
        DescriptionProperty     $description,
        DeterminerProperty       $determiner
    ) {
        $this->type = $this->getType();
        $this->url  = $url;
        $this->title = $title;
        $this->images = $images;
        $this->description = $description;
        $this->determiner = $determiner;
    }

    abstract protected function getType(): TypeProperty;
}
