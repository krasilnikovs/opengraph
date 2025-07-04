<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\MusicAlbumPropertyExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\MusicAlbumObject;
use Krasilnikovs\Opengraph\OpengraphScraper;

final readonly class MusicAlbumObjectTransformer implements ObjectTransformerInterface
{
    public function supports(OpengraphScraper $scraper): bool
    {
        $extractor = MusicAlbumPropertyExtractor::fromScraper($scraper);

        return $extractor->type() === MusicAlbumObject::getType();
    }

    public function toObject(OpengraphScraper $scraper): AbstractObject
    {
        $extractor = MusicAlbumPropertyExtractor::fromScraper($scraper);

        return new MusicAlbumObject(
            url:         $extractor->url(),
            title:       $extractor->title(),
            description: $extractor->description(),
            siteName:    $extractor->siteName(),
            determiner:  $extractor->determiner(),
            images:      $extractor->images(),
            audios:      $extractor->audios(),
            videos:      $extractor->videos(),
            releaseDate: $extractor->releaseDate(),
            musicians:   $extractor->musicians(),
            songs:       $extractor->songs(),
        );
    }
}
