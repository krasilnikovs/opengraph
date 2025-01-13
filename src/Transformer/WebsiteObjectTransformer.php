<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\PropertyExtractorInterface;
use Krasilnikovs\Opengraph\Object\AbstractBaseObject;
use Krasilnikovs\Opengraph\Object\WebsiteObject;

final readonly class WebsiteObjectTransformer implements ObjectTransformerInterface
{
    public function supports(PropertyExtractorInterface $extractor): bool
    {
        return $extractor->type()->isWebsite();
    }

    public function toObject(PropertyExtractorInterface $extractor): AbstractBaseObject
    {
        return new WebsiteObject(
            url: $extractor->url(),
            title: $extractor->title(),
            images: $extractor->images(),
        );
    }
}
