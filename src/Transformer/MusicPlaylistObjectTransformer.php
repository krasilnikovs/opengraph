<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\MusicPlaylistObject;
use Krasilnikovs\Opengraph\Property\Extractor\MusicPlaylistPropertyExtractor;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;

final readonly class MusicPlaylistObjectTransformer implements ObjectTransformerInterface
{
    public function supports(MetaScraperInterface $scraper): bool
    {
        $extractor = MusicPlaylistPropertyExtractor::fromMetaScraper($scraper);

        return $extractor->type() === MusicPlaylistObject::getType();
    }

    public function toObject(MetaScraperInterface $scraper): AbstractObject
    {
        $extractor = MusicPlaylistPropertyExtractor::fromMetaScraper($scraper);

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
