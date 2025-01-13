<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\Model\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Model\Property\ImageUrlProperty;
use Krasilnikovs\Opengraph\Model\Property\TitleProperty;
use Krasilnikovs\Opengraph\Model\Property\TypeProperty;
use Krasilnikovs\Opengraph\Model\Property\UrlProperty;

interface PropertyExtractorInterface
{
    public function type(): TypeProperty;
    public function url(): UrlProperty;
    public function title(): TitleProperty;

    /**
     * @return ImagePropertyCollection<ImageUrlProperty>
     */
    public function images(): ImagePropertyCollection;
}
