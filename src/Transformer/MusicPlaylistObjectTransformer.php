<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\MusicPlaylistPropertyExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\MusicPlaylistObject;
use Krasilnikovs\Opengraph\OpengraphScraper;

final readonly class MusicPlaylistObjectTransformer implements ObjectTransformerInterface
{
    public function supports(OpengraphScraper $scraper): bool
    {
        $extractor = MusicPlaylistPropertyExtractor::fromScraper($scraper);

        return $extractor->type() === MusicPlaylistObject::getType();
    }

    public function toObject(OpengraphScraper $scraper): AbstractObject
    {
        $extractor = MusicPlaylistPropertyExtractor::fromScraper($scraper);

        return new MusicPlaylistObject(
            url:         $extractor->url(),
            title:       $extractor->title(),
            description: $extractor->description(),
            siteName:    $extractor->siteName(),
            determiner:  $extractor->determiner(),
            images:      $extractor->images(),
            audios:      $extractor->audios(),
            videos:      $extractor->videos(),
            creators:    $extractor->creators(),
            songs:       $extractor->songs(),
        );
    }

}
