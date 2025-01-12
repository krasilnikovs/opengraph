<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\MetaExtractorInterface;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\WebsiteObject;
use Krasilnikovs\Opengraph\Property\Images;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;

final readonly class WebsiteObjectTransformer implements ObjectTransformerInterface
{
    public function supports(MetaExtractorInterface $extractor): bool
    {
        return $extractor->type() === TypeProperty::WEBSITE;
    }

    public function toObject(MetaExtractorInterface $extractor): AbstractObject
    {
        $url = UrlProperty::fromString($extractor->url());
        $title = TitleProperty::fromString($extractor->title());
        $images = Images::fromArray($extractor->images());

        return new WebsiteObject(
            url: $url,
            title: $title,
            images: $images,
        );
    }
}
