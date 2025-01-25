<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\WebsitePropertyExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\WebsiteObject;
use Krasilnikovs\Opengraph\Scraper;

final readonly class WebsiteObjectTransformer implements ObjectTransformerInterface
{
    public function supports(Scraper $scraper): bool
    {
        $extractor = WebsitePropertyExtractor::fromMetaScraper($scraper);

        return $extractor->type() === WebsiteObject::getType();
    }

    public function toObject(Scraper $scraper): AbstractObject
    {
        $extractor = WebsitePropertyExtractor::fromMetaScraper($scraper);

        return new WebsiteObject(
            url:         $extractor->url(),
            title:       $extractor->title(),
            description: $extractor->description(),
            siteName:    $extractor->siteName(),
            determiner:  $extractor->determiner(),
            images:      $extractor->images(),
            audios:      $extractor->audios(),
            videos:      $extractor->videos(),
        );
    }


}
