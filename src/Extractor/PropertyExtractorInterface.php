<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\Property\AudioProperty;
use Krasilnikovs\Opengraph\Property\AudioPropertyCollection;
use Krasilnikovs\Opengraph\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Property\ImageUrlProperty;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;

interface PropertyExtractorInterface
{
    public function type(): TypeProperty;
    public function url(): UrlProperty;
    public function title(): TitleProperty;

    /**
     * @return ImagePropertyCollection<ImageUrlProperty>
     */
    public function images(): ImagePropertyCollection;

    /**
     * @return AudioPropertyCollection<AudioProperty>
     */
    public function audios(): AudioPropertyCollection;
}
