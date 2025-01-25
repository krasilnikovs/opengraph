<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\MusicAlbumPropertyExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\MusicAlbumObject;
use Krasilnikovs\Opengraph\Scraper;

final readonly class MusicAlbumObjectTransformer implements ObjectTransformerInterface
{
    public function supports(Scraper $scraper): bool
    {
        $extractor = MusicAlbumPropertyExtractor::fromMetaScraper($scraper);

        return $extractor->type() === MusicAlbumObject::getType();
    }

    public function toObject(Scraper $scraper): AbstractObject
    {
        $extractor = MusicAlbumPropertyExtractor::fromMetaScraper($scraper);

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
