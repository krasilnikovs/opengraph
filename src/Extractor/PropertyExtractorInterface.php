<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\Property\ImageProperty;
use Krasilnikovs\Opengraph\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;

interface PropertyExtractorInterface
{
    public function type(): TypeProperty;
    public function url(): UrlProperty;
    public function title(): TitleProperty;

    /**
     * @return ImagePropertyCollection<ImageProperty>
     */
    public function images(): ImagePropertyCollection;
}
