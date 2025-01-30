<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\BookPropertyExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\BookObject;
use Krasilnikovs\Opengraph\OpengraphScraper;

final readonly class BookObjectTransformer implements ObjectTransformerInterface
{
    public function supports(OpengraphScraper $scraper): bool
    {
        $extractor = BookPropertyExtractor::fromScraper($scraper);

        return $extractor->type() === BookObject::getType();
    }

    public function toObject(OpengraphScraper $scraper): AbstractObject
    {
        $extractor = BookPropertyExtractor::fromScraper($scraper);

        return new BookObject(
            url:         $extractor->url(),
            title:       $extractor->title(),
            description: $extractor->description(),
            siteName:    $extractor->siteName(),
            determiner:  $extractor->determiner(),
            images:      $extractor->images(),
            audios:      $extractor->audios(),
            videos:      $extractor->videos(),
            isbn:        $extractor->isbn(),
            author:      $extractor->author(),
            releaseDate: $extractor->releaseDate(),
            tags:        $extractor->tags(),
        );
    }
}
