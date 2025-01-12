<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Builder;

use Krasilnikovs\Opengraph\AbstractObject;
use Krasilnikovs\Opengraph\Extractor\MetaExtractor;
use Krasilnikovs\Opengraph\Property\Images;
use Krasilnikovs\Opengraph\Property\Title;
use Krasilnikovs\Opengraph\Property\Type;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\WebsiteObject;

final readonly class WebsiteObjectTransformer implements ObjectTransformerInterface
{
    public function supports(MetaExtractor $extractor): bool
    {
        return $extractor->type() === Type::WEBSITE;
    }

    public function toObject(MetaExtractor $extractor): AbstractObject
    {
        $url = Url::fromString($extractor->url());
        $title = Title::fromString($extractor->title());
        $images = Images::fromIterable($extractor->images());

        return new WebsiteObject(
            url: $url,
            title: $title,
            images: $images,
        );
    }
}
