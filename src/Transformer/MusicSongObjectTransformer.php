<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\MusicSongPropertyExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\MusicSongObject;
use Krasilnikovs\Opengraph\OpengraphScraper;

final readonly class MusicSongObjectTransformer implements ObjectTransformerInterface
{
    public function supports(OpengraphScraper $scraper): bool
    {
        $extractor = MusicSongPropertyExtractor::fromMetaScraper($scraper);

        return $extractor->type() === MusicSongObject::getType();
    }

    public function toObject(OpengraphScraper $scraper): AbstractObject
    {
        $extractor = MusicSongPropertyExtractor::fromMetaScraper($scraper);

        return new MusicSongObject(
            url:         $extractor->url(),
            title:       $extractor->title(),
            description: $extractor->description(),
            siteName:    $extractor->siteName(),
            determiner:  $extractor->determiner(),
            images:      $extractor->images(),
            audios:      $extractor->audios(),
            videos:      $extractor->videos(),
            duration:    $extractor->duration(),
            album:       $extractor->album(),
            musicians:   $extractor->musicians(),
        );
    }
}
